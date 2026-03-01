<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentAnalyticsController extends Controller
{
    /**
     * Get payment analytics overview
     */
    public function getOverview(Request $request)
    {
        try {
            $period = $request->get('period', '30'); // days
            $startDate = Carbon::now()->subDays($period);

            // Total revenue
            $totalRevenue = Payment::where('payment_status_id', 2) // Paid status
                ->where('created_at', '>=', $startDate)
                ->sum('price');

            // Total transactions
            $totalTransactions = Payment::where('created_at', '>=', $startDate)->count();

            // Successful payments
            $successfulPayments = Payment::where('payment_status_id', 2)
                ->where('created_at', '>=', $startDate)
                ->count();

            // Failed payments
            $failedPayments = Payment::where('payment_status_id', 3) // Failed status
                ->where('created_at', '>=', $startDate)
                ->count();

            // Success rate
            $successRate = $totalTransactions > 0 ? ($successfulPayments / $totalTransactions) * 100 : 0;

            // Average transaction value
            $averageTransaction = $successfulPayments > 0 ? $totalRevenue / $successfulPayments : 0;

            // Payment method breakdown
            $paymentMethods = Payment::select('payment_method_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(price) as total'))
                ->where('payment_status_id', 2)
                ->where('created_at', '>=', $startDate)
                ->with('paymentMethod')
                ->groupBy('payment_method_id')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'overview' => [
                        'total_revenue' => round($totalRevenue, 2),
                        'total_transactions' => $totalTransactions,
                        'successful_payments' => $successfulPayments,
                        'failed_payments' => $failedPayments,
                        'success_rate' => round($successRate, 2),
                        'average_transaction' => round($averageTransaction, 2),
                    ],
                    'payment_methods' => $paymentMethods,
                    'period' => $period
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch payment analytics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get daily revenue chart data
     */
    public function getDailyRevenue(Request $request)
    {
        try {
            $days = $request->get('days', 30);
            $startDate = Carbon::now()->subDays($days)->startOfDay();

            $dailyRevenue = Payment::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(price) as revenue'),
                    DB::raw('COUNT(*) as transactions')
                )
                ->where('payment_status_id', 2) // Paid status
                ->where('created_at', '>=', $startDate)
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $dailyRevenue
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch daily revenue: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payment status distribution
     */
    public function getPaymentStatusDistribution(Request $request)
    {
        try {
            $period = $request->get('period', '30');
            $startDate = Carbon::now()->subDays($period);

            $statusDistribution = Payment::select('payment_status_id', DB::raw('COUNT(*) as count'))
                ->where('created_at', '>=', $startDate)
                ->with('paymentStatus')
                ->groupBy('payment_status_id')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $statusDistribution
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch payment status distribution: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get top services by revenue
     */
    public function getTopServicesByRevenue(Request $request)
    {
        try {
            $period = $request->get('period', '30');
            $limit = $request->get('limit', 10);
            $startDate = Carbon::now()->subDays($period);

            $topServices = Payment::select(
                    'bookings.e_service_id',
                    DB::raw('SUM(payments.price) as total_revenue'),
                    DB::raw('COUNT(payments.id) as transaction_count')
                )
                ->join('bookings', 'payments.booking_id', '=', 'bookings.id')
                ->join('e_services', 'bookings.e_service_id', '=', 'e_services.id')
                ->where('payments.payment_status_id', 2)
                ->where('payments.created_at', '>=', $startDate)
                ->groupBy('bookings.e_service_id')
                ->orderBy('total_revenue', 'desc')
                ->limit($limit)
                ->with(['booking.eService'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $topServices
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch top services: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent transactions
     */
    public function getRecentTransactions(Request $request)
    {
        try {
            $limit = $request->get('limit', 20);

            $recentTransactions = Payment::with([
                    'paymentMethod',
                    'paymentStatus',
                    'booking.eService',
                    'booking.user'
                ])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $recentTransactions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch recent transactions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payment trends comparison
     */
    public function getPaymentTrends(Request $request)
    {
        try {
            $currentPeriod = $request->get('period', '30');
            $currentStart = Carbon::now()->subDays($currentPeriod);
            $previousStart = Carbon::now()->subDays($currentPeriod * 2);
            $previousEnd = Carbon::now()->subDays($currentPeriod);

            // Current period stats
            $currentRevenue = Payment::where('payment_status_id', 2)
                ->where('created_at', '>=', $currentStart)
                ->sum('price');

            $currentTransactions = Payment::where('created_at', '>=', $currentStart)->count();

            // Previous period stats
            $previousRevenue = Payment::where('payment_status_id', 2)
                ->whereBetween('created_at', [$previousStart, $previousEnd])
                ->sum('price');

            $previousTransactions = Payment::whereBetween('created_at', [$previousStart, $previousEnd])->count();

            // Calculate growth rates
            $revenueGrowth = $previousRevenue > 0 ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;
            $transactionGrowth = $previousTransactions > 0 ? (($currentTransactions - $previousTransactions) / $previousTransactions) * 100 : 0;

            return response()->json([
                'success' => true,
                'data' => [
                    'current' => [
                        'revenue' => round($currentRevenue, 2),
                        'transactions' => $currentTransactions
                    ],
                    'previous' => [
                        'revenue' => round($previousRevenue, 2),
                        'transactions' => $previousTransactions
                    ],
                    'growth' => [
                        'revenue' => round($revenueGrowth, 2),
                        'transactions' => round($transactionGrowth, 2)
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch payment trends: ' . $e->getMessage()
            ], 500);
        }
    }
}
