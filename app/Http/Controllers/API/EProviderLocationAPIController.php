<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\BookingRepository;
use App\Repositories\EProviderLocationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\EProviderLocation;
use phpDocumentor\Reflection\Types\This;
use Prettus\Validator\Exceptions\ValidatorException;

class EProviderLocationAPIController extends Controller
{
    /** @var  BookingRepository */
    private $bookingRepository;

    /** @var  EProviderLocationRepository */
    private $userLocationRepository;

    public function __construct(BookingRepository $bookingRepo, EProviderLocationRepository $userLocationRepo)
    {
        $this->bookingRepository = $bookingRepo;
        $this->userLocationRepository = $userLocationRepo;
    }
    public function updateLocation(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'e_provider_id' => EProviderLocation::$rules['e_provider_id'],
            'booking_id' => EProviderLocation::$rules['booking_id'],
            'latitude' => EProviderLocation::$rules['latitude'],
            'longitude' => EProviderLocation::$rules['longitude'],
        ]);

        try {
            $location = $this->userLocationRepository->updateOrCreate(
                ['e_provider_id' => $request->e_provider_id, 'booking_id' => $request->booking_id],
                ['latitude' => $request->latitude, 'longitude' => $request->longitude]);

        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }


        return $this->sendResponse($location->toArray(), __('lang.saved_successfully', ['operator' => __('lang.location')]));
    }

    public function getLocation($e_provider_id, $booking_id): JsonResponse
    {
        $query = $this->userLocationRepository->findByField('e_provider_id', $e_provider_id);
        $location = $query->where('booking_id', $booking_id)->first();

        if (!$location) {
            return $this->sendResponse(false, 'Location not found');
        }

        return $this->sendResponse($location->toArray(), 'Location retrieved successfully');
    }
}
