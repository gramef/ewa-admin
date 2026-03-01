<?php

namespace App\Http\Controllers\API\EProvider;

use App\Http\Controllers\Controller;
use App\Models\EProvider;
use App\Models\Address;
use App\Models\AvailabilityHour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

/**
 * Vendor Onboarding API Controller
 *
 * Multi-step onboarding flow for new vendors:
 * Step 1: Account (UserAPIController@register)
 * Step 2: Business profile
 * Step 3: Address & availability
 * Step 4: Review & complete
 */
class OnboardingAPIController extends Controller
{
    /**
     * Get onboarding status for authenticated vendor.
     * GET /provider/onboarding/status
     */
    public function status(Request $request): JsonResponse
    {
        $user = auth()->user();
        $provider = $this->getUserProvider($user);

        $status = [
            'has_account' => true,
            'has_business_profile' => $provider !== null,
            'has_address' => $provider ? $provider->addresses()->count() > 0 : false,
            'has_availability' => $provider ? $provider->availabilityHours()->count() > 0 : false,
            'is_accepted' => $provider ? (bool) $provider->accepted : false,
            'is_complete' => false,
            'provider_id' => $provider ? $provider->id : null,
            'provider' => $provider ? $provider->load(['eProviderType', 'addresses', 'availabilityHours'])->toArray() : null,
        ];

        $status['is_complete'] = $status['has_business_profile'] && $status['has_address'];

        return $this->sendResponse($status, 'Onboarding status retrieved');
    }

    /**
     * Step 2: Create or update business profile.
     * POST /provider/onboarding/business
     */
    public function business(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:127',
                'e_provider_type_id' => 'required|exists:e_provider_types,id',
                'description' => 'nullable|string|max:1000',
                'phone_number' => 'nullable|string|max:50',
                'mobile_number' => 'nullable|string|max:50',
                'availability_range' => 'nullable|numeric|min:0.01|max:9999999.99',
            ]);
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        }

        $user = auth()->user();
        $provider = $this->getUserProvider($user);

        try {
            DB::beginTransaction();

            $data = [
                'name' => $request->input('name'),
                'e_provider_type_id' => $request->input('e_provider_type_id'),
                'description' => $request->input('description', ''),
                'phone_number' => $request->input('phone_number', $user->phone_number),
                'mobile_number' => $request->input('mobile_number', $user->phone_number),
                'availability_range' => $request->input('availability_range', 30),
                'available' => true,
                'featured' => false,
                'accepted' => false,
            ];

            if ($provider) {
                $provider->update($data);
            } else {
                $provider = EProvider::create($data);
                $provider->users()->attach($user->id);
            }

            DB::commit();

            return $this->sendResponse(
                $provider->load('eProviderType')->toArray(),
                'Business profile saved successfully'
            );
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to save business profile: ' . $e->getMessage());
        }
    }

    /**
     * Step 3a: Set business address.
     * POST /provider/onboarding/address
     */
    public function address(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'address' => 'required|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'description' => 'nullable|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        }

        $user = auth()->user();
        $provider = $this->getUserProvider($user);

        if (!$provider) {
            return $this->sendError('Please complete your business profile first');
        }

        try {
            DB::beginTransaction();

            $address = Address::updateOrCreate(
                ['address' => $request->input('address')],
                [
                    'address' => $request->input('address'),
                    'latitude' => $request->input('latitude', 0),
                    'longitude' => $request->input('longitude', 0),
                    'description' => $request->input('description', 'Business Address'),
                    'user_id' => $user->id,
                ]
            );

            if (!$provider->addresses()->where('addresses.id', $address->id)->exists()) {
                $provider->addresses()->attach($address->id);
            }

            DB::commit();
            return $this->sendResponse($address->toArray(), 'Business address saved');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to save address: ' . $e->getMessage());
        }
    }

    /**
     * Step 3b: Set default availability hours.
     * POST /provider/onboarding/availability
     */
    public function availability(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'hours' => 'required|array',
                'hours.*.day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
                'hours.*.start_at' => 'required|string',
                'hours.*.end_at' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        }

        $user = auth()->user();
        $provider = $this->getUserProvider($user);

        if (!$provider) {
            return $this->sendError('Please complete your business profile first');
        }

        try {
            DB::beginTransaction();
            AvailabilityHour::where('e_provider_id', $provider->id)->delete();

            $hours = [];
            foreach ($request->input('hours') as $hour) {
                $hours[] = AvailabilityHour::create([
                    'e_provider_id' => $provider->id,
                    'day' => $hour['day'],
                    'start_at' => $hour['start_at'],
                    'end_at' => $hour['end_at'],
                    'data' => $hour['data'] ?? '',
                ]);
            }

            DB::commit();
            return $this->sendResponse($hours, 'Availability hours saved');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to save availability: ' . $e->getMessage());
        }
    }

    /**
     * Mark onboarding as complete.
     * POST /provider/onboarding/complete
     */
    public function complete(Request $request): JsonResponse
    {
        $user = auth()->user();
        $provider = $this->getUserProvider($user);

        if (!$provider) {
            return $this->sendError('Please complete your business profile first');
        }

        if ($provider->addresses()->count() === 0) {
            return $this->sendError('Please add a business address before completing onboarding');
        }

        return $this->sendResponse(
            $provider->load(['eProviderType', 'addresses', 'availabilityHours', 'users'])->toArray(),
            'Onboarding complete! Your profile is pending admin approval.'
        );
    }

    /**
     * Get the provider entity linked to this user.
     */
    private function getUserProvider($user)
    {
        return EProvider::whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->first();
    }
}
