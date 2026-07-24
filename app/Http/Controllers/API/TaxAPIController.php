<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Public Tax API Controller
 * Returns all configured taxes for client booking flow
 */
class TaxAPIController extends Controller
{
    /**
     * List all taxes (public endpoint for client booking flow)
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $taxes = Tax::all();
            return $this->sendResponse($taxes->toArray(), 'Taxes retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }
}
