<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use App\Models\Booking;
use App\Models\EProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Public Tax (VAT) API Controller
 * Returns all configured taxes for client booking flow.
 * Applies UK VAT threshold: 0% VAT until provider exceeds £50,000 revenue.
 */
class TaxAPIController extends Controller
{
    /**
     * List taxes for a given provider (or globally).
     * If provider is below £50k revenue threshold, taxes are returned with value=0.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $taxes = Tax::all();

            // Check if a provider ID is passed — apply VAT threshold
            $providerId = $request->query('provider_id') ?? $request->query('e_provider_id');
            if ($providerId) {
                $provider = EProvider::find($providerId);
                if ($provider && $this->isProviderBelowVatThreshold($provider)) {
                    // Zero out taxes for sub-threshold providers
                    $taxes = $taxes->map(function ($tax) {
                        $t = $tax->toArray();
                        $t['value'] = 0;
                        $t['name'] = $this->renameToVat($t['name'] ?? 'VAT');
                        $t['below_vat_threshold'] = true;
                        return $t;
                    });
                    return $this->sendResponse($taxes->toArray(), 'VAT exempt — provider below £50,000 threshold');
                }
            }

            // Rename tax labels to VAT
            $taxes = $taxes->map(function ($tax) {
                $t = $tax->toArray();
                $t['name'] = $this->renameToVat($t['name'] ?? 'VAT');
                return $t;
            });

            return $this->sendResponse($taxes->toArray(), 'Taxes retrieved successfully');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * Check if provider revenue is below UK VAT threshold (£50,000).
     */
    private function isProviderBelowVatThreshold(EProvider $provider): bool
    {
        $vatThreshold = 50000;

        try {
            $totalRevenue = Booking::where('e_provider', 'LIKE', '%"id":' . $provider->id . '%')
                ->where('booking_status_id', '>=', 5)
                ->sum('total');

            if ($totalRevenue <= 0) {
                $totalRevenue = \App\Models\Payment::whereHas('booking', function ($q) use ($provider) {
                    $q->where('e_provider', 'LIKE', '%"id":' . $provider->id . '%');
                })->sum('amount');
            }

            return $totalRevenue < $vatThreshold;
        } catch (\Throwable $e) {
            return true;
        }
    }

    /**
     * Rename tax labels to VAT for UK compliance.
     */
    private function renameToVat($name)
    {
        if (is_object($name)) {
            $name = (array) $name;
        }
        if (is_array($name)) {
            // Translatable field (e.g. ['en' => 'Tax', 'fr' => 'Taxe'])
            foreach ($name as $locale => $val) {
                if (is_string($val)) {
                    $name[$locale] = preg_replace('/\btax\b/i', 'VAT', $val);
                }
            }
            return $name;
        }
        if (is_string($name)) {
            return preg_replace('/\btax\b/i', 'VAT', $name);
        }
        return 'VAT';
    }
}
