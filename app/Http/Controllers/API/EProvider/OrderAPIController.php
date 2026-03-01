<?php

namespace App\Http\Controllers\API\EProvider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\EProvider;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Class OrderAPIController
 * @package App\Http\Controllers\API\EProvider
 */
class OrderAPIController extends Controller
{
    /**
     * Display a listing of the provider's orders
     * GET /api/provider/orders
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $eProvider = $user->eProvider;
            
            if (!$eProvider) {
                return response()->json([
                    'success' => false,
                    'message' => 'Provider not found'
                ], 404);
            }

            $perPage = $request->get('per_page', 15);
            $status = $request->get('status');
            $dateFrom = $request->get('date_from');
            $dateTo = $request->get('date_to');
            
            $query = Order::whereHas('orderItems.product', function ($q) use ($eProvider) {
                $q->where('store_id', $eProvider->id);
            })
            ->with([
                'user:id,name,email,phone',
                'orderItems.product:id,name,price,images',
                'deliveryAddress'
            ])
            ->orderBy('created_at', 'desc');

            // Filter by status
            if ($status) {
                $query->where('status', $status);
            }

            // Filter by date range
            if ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            }
            if ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            }

            $orders = $query->paginate($perPage);

            // Calculate order totals for this provider only
            $orders->getCollection()->transform(function ($order) use ($eProvider) {
                $providerItems = $order->orderItems->filter(function ($item) use ($eProvider) {
                    return $item->product && $item->product->store_id == $eProvider->id;
                });
                
                $order->provider_total = $providerItems->sum(function ($item) {
                    return $item->quantity * $item->price;
                });
                
                $order->provider_items_count = $providerItems->count();
                $order->orderItems = $providerItems->values();
                
                return $order;
            });

            return response()->json([
                'success' => true,
                'data' => $orders->items(),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified order
     * GET /api/provider/orders/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $user = Auth::user();
            $eProvider = $user->eProvider;
            
            $order = Order::whereHas('orderItems.product', function ($q) use ($eProvider) {
                $q->where('store_id', $eProvider->id);
            })
            ->with([
                'user:id,name,email,phone',
                'orderItems.product:id,name,price,images,description',
                'deliveryAddress',
                'payment'
            ])
            ->find($id);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Filter order items to show only this provider's products
            $providerItems = $order->orderItems->filter(function ($item) use ($eProvider) {
                return $item->product && $item->product->store_id == $eProvider->id;
            });

            $order->provider_total = $providerItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });
            
            $order->provider_items_count = $providerItems->count();
            $order->orderItems = $providerItems->values();

            return response()->json([
                'success' => true,
                'data' => $order
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update order status
     * PUT /api/provider/orders/{id}/status
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $eProvider = $user->eProvider;
            
            $request->validate([
                'status' => 'required|in:pending,confirmed,preparing,ready,shipped,delivered,cancelled',
                'notes' => 'nullable|string|max:500'
            ]);

            $order = Order::whereHas('orderItems.product', function ($q) use ($eProvider) {
                $q->where('store_id', $eProvider->id);
            })->find($id);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $oldStatus = $order->status;
            $newStatus = $request->status;

            // Validate status transitions
            $allowedTransitions = [
                'pending' => ['confirmed', 'cancelled'],
                'confirmed' => ['preparing', 'cancelled'],
                'preparing' => ['ready', 'cancelled'],
                'ready' => ['shipped', 'cancelled'],
                'shipped' => ['delivered'],
                'delivered' => [],
                'cancelled' => []
            ];

            if (!in_array($newStatus, $allowedTransitions[$oldStatus] ?? [])) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot change status from {$oldStatus} to {$newStatus}"
                ], 400);
            }

            // Update order status
            $order->update([
                'status' => $newStatus,
                'provider_notes' => $request->notes
            ]);

            // Log status change
            DB::table('order_status_logs')->insert([
                'order_id' => $order->id,
                'provider_id' => $eProvider->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'notes' => $request->notes,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'data' => [
                    'order_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'updated_at' => $order->updated_at
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order analytics for the provider
     * GET /api/provider/order-analytics
     */
    public function analytics(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $eProvider = $user->eProvider;
            
            $period = $request->get('period', '30'); // days
            $startDate = now()->subDays($period);

            // Total orders
            $totalOrders = Order::whereHas('orderItems.product', function ($q) use ($eProvider) {
                $q->where('store_id', $eProvider->id);
            })->where('created_at', '>=', $startDate)->count();

            // Orders by status
            $ordersByStatus = Order::whereHas('orderItems.product', function ($q) use ($eProvider) {
                $q->where('store_id', $eProvider->id);
            })
            ->where('created_at', '>=', $startDate)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

            // Total revenue
            $totalRevenue = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.store_id', $eProvider->id)
                ->where('orders.created_at', '>=', $startDate)
                ->where('orders.status', '!=', 'cancelled')
                ->sum(DB::raw('order_items.quantity * order_items.price'));

            // Average order value
            $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

            // Top selling products
            $topProducts = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('products.store_id', $eProvider->id)
                ->where('orders.created_at', '>=', $startDate)
                ->where('orders.status', '!=', 'cancelled')
                ->select(
                    'products.id',
                    'products.name',
                    DB::raw('SUM(order_items.quantity) as total_sold'),
                    DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
                )
                ->groupBy('products.id', 'products.name')
                ->orderBy('total_sold', 'desc')
                ->limit(5)
                ->get();

            // Daily sales for the period
            $dailySales = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.store_id', $eProvider->id)
                ->where('orders.created_at', '>=', $startDate)
                ->where('orders.status', '!=', 'cancelled')
                ->select(
                    DB::raw('DATE(orders.created_at) as date'),
                    DB::raw('COUNT(DISTINCT orders.id) as orders_count'),
                    DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
                )
                ->groupBy(DB::raw('DATE(orders.created_at)'))
                ->orderBy('date')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'period_days' => $period,
                    'total_orders' => $totalOrders,
                    'total_revenue' => round($totalRevenue, 2),
                    'average_order_value' => round($avgOrderValue, 2),
                    'orders_by_status' => $ordersByStatus,
                    'top_products' => $topProducts,
                    'daily_sales' => $dailySales
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch analytics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order status options
     * GET /api/provider/order-statuses
     */
    public function getStatusOptions(): JsonResponse
    {
        $statuses = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'preparing' => 'Preparing',
            'ready' => 'Ready for Pickup/Delivery',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];

        return response()->json([
            'success' => true,
            'data' => $statuses
        ]);
    }
}
