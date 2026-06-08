<?php

namespace App\Http\Controllers\API\EProvider;

use App\Http\Controllers\Controller;
use App\Models\EProvider;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OnboardingAPIController extends Controller
{
    /**
     * Step 1: Set up business details
     */
    public function business(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required|max:127',
                'description' => 'nullable|max:500',
                'phone_number' => 'nullable|max:50',
                'mobile_number' => 'nullable|max:50',
                'e_provider_type_id' => 'required|exists:e_provider_types,id',
            ]);

            $user = auth()->user();
            if (!$user) {
                return $this->sendError('Unauthenticated', 401);
            }

            // Check if user already has a provider
            $provider = $user->eProviders()->first();

            $fields = ['name', 'description', 'phone_number', 'mobile_number', 'e_provider_type_id'];

            if ($provider) {
                $provider->update($request->only($fields));
            } else {
                $provider = EProvider::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'phone_number' => $request->phone_number,
                    'mobile_number' => $request->mobile_number,
                    'e_provider_type_id' => $request->e_provider_type_id,
                    'availability_range' => 30,
                    'available' => false,
                    'featured' => false,
                    'accepted' => false,
                ]);
                // Link user to provider
                $provider->users()->attach($user->id);
            }

            // Handle image upload UUIDs if provided
            if ($request->has('image') && is_array($request->image)) {
                $provider->image = $request->image;
                $provider->save();
            }

            return $this->sendResponse($provider->toArray(), 'Business details saved');
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * Step 2: Set business address
     */
    public function address(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'address' => 'required|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]);

            $user = auth()->user();
            $provider = $user->eProviders()->first();

            if (!$provider) {
                return $this->sendError('Please complete the business step first', 200);
            }

            // addresses() is BelongsToMany — create Address, then attach
            $address = $provider->addresses()->first();
            $data = [
                'address' => $request->address,
                'latitude' => $request->latitude ?? 0,
                'longitude' => $request->longitude ?? 0,
                'user_id' => $user->id,
            ];

            if ($address) {
                $address->update($data);
            } else {
                $address = \App\Models\Address::create($data);
                $provider->addresses()->attach($address->id);
            }

            return $this->sendResponse($provider->load('addresses')->toArray(), 'Address saved');
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * Step 3: Set availability hours
     */
    public function availability(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $provider = $user->eProviders()->first();

            if (!$provider) {
                return $this->sendError('Please complete the business step first', 200);
            }

            // Accept both 'availability_hours' and 'hours' field names from frontend
            $hoursData = $request->availability_hours ?? $request->hours ?? null;

            if ($hoursData && is_array($hoursData)) {
                // Clear existing and set new hours
                $provider->availabilityHours()->delete();
                foreach ($hoursData as $hours) {
                    $provider->availabilityHours()->create($hours);
                }
            }

            return $this->sendResponse($provider->load('availabilityHours')->toArray(), 'Availability saved');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 200);

        }
    }

    /**
     * Step 4: Complete onboarding
     */
    public function complete(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $provider = $user->eProviders()->first();

            if (!$provider) {
                return $this->sendError('Please complete the business step first', 200);
            }

            $provider->update(['available' => true]);

            return $this->sendResponse($provider->toArray(), 'Onboarding complete!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * Check onboarding status
     */
    public function status(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $provider = $user->eProviders()->first();

            $status = [
                'has_provider' => !is_null($provider),
                'has_business_profile' => !is_null($provider),
                'has_address' => $provider ? $provider->addresses()->exists() : false,
                'has_availability' => $provider ? $provider->availabilityHours()->exists() : false,
                'is_available' => $provider ? (bool)$provider->available : false,
                'is_accepted' => $provider ? (bool)$provider->accepted : false,
            ];

            // Include the provider object so the frontend can pre-fill the onboarding form
            if ($provider) {
                $status['provider'] = $provider->load(['addresses', 'availabilityHours', 'eProviderType'])->toArray();
            }

            return $this->sendResponse($status, 'Onboarding status retrieved');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }
}
