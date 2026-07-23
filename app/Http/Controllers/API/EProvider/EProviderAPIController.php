<?php

namespace App\Http\Controllers\API\EProvider;

use App\Http\Controllers\Controller;
use App\Models\EProvider;
use App\Repositories\EProviderRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EProviderAPIController extends Controller
{
    private $eProviderRepository;

    public function __construct(EProviderRepository $eProviderRepository)
    {
        $this->eProviderRepository = $eProviderRepository;
    }

    /**
     * List the authenticated user's providers
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return $this->sendError('Unauthenticated', 401);
            }
            $eProviders = $user->eProviders()->with(['addresses', 'media', 'eProviderType'])->get();
            return $this->sendResponse($eProviders->toArray(), 'E Providers retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * Show a specific provider
     */
    public function show(int $id, Request $request): JsonResponse
    {
        try {
            $eProvider = $this->eProviderRepository->findWithoutFail($id);
            if (empty($eProvider)) {
                return $this->sendError('EProvider not found');
            }
            return $this->sendResponse($eProvider->toArray(), 'E Provider retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }
}
