<?php

namespace App\Http\Controllers\API\EProvider;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\EProvider;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Exception;

/**
 * Class ProductAPIController
 * @package App\Http\Controllers\API\EProvider
 */
class ProductAPIController extends Controller
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the provider's products
     * GET /api/provider/products
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
            $search = $request->get('search');
            $featured = $request->get('featured');
            
            $query = Product::where('store_id', $eProvider->id)
                ->with(['categories', 'images', 'store'])
                ->orderBy('created_at', 'desc');

            if ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            }

            if ($featured !== null) {
                $query->where('featured', $featured);
            }

            $products = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created product
     * POST /api/provider/products
     */
    public function store(CreateProductRequest $request): JsonResponse
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

            $input = $request->validated();
            $input['store_id'] = $eProvider->id;
            
            // Set default approval status for new products
            $input['approved'] = false;
            
            $product = $this->productRepository->create($input);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $product->addMediaFromRequest('images')
                           ->each(function ($fileAdder) {
                               $fileAdder->toMediaCollection('images');
                           });
                }
            }

            // Attach categories
            if (isset($input['category_ids'])) {
                $product->categories()->sync($input['category_ids']);
            }

            $product->load(['categories', 'images', 'store']);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully and pending approval',
                'data' => $product
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified product
     * GET /api/provider/products/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $user = Auth::user();
            $eProvider = $user->eProvider;
            
            $product = Product::where('id', $id)
                             ->where('store_id', $eProvider->id)
                             ->with(['categories', 'images', 'store'])
                             ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $product
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified product
     * PUT /api/provider/products/{id}
     */
    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $eProvider = $user->eProvider;
            
            $product = Product::where('id', $id)
                             ->where('store_id', $eProvider->id)
                             ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            $input = $request->validated();
            
            // Reset approval status when product is updated
            $input['approved'] = false;
            
            $product = $this->productRepository->update($input, $id);

            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $product->addMediaFromRequest('images')
                           ->each(function ($fileAdder) {
                               $fileAdder->toMediaCollection('images');
                           });
                }
            }

            // Update categories
            if (isset($input['category_ids'])) {
                $product->categories()->sync($input['category_ids']);
            }

            $product->load(['categories', 'images', 'store']);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully and pending approval',
                'data' => $product
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified product
     * DELETE /api/provider/products/{id}
     */
    public function destroy($id): JsonResponse
    {
        try {
            $user = Auth::user();
            $eProvider = $user->eProvider;
            
            $product = Product::where('id', $id)
                             ->where('store_id', $eProvider->id)
                             ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // Soft delete the product
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product analytics for the provider
     * GET /api/provider/product-analytics
     */
    public function analytics(): JsonResponse
    {
        try {
            $user = Auth::user();
            $eProvider = $user->eProvider;
            
            $totalProducts = Product::where('store_id', $eProvider->id)->count();
            $approvedProducts = Product::where('store_id', $eProvider->id)
                                     ->where('approved', true)
                                     ->count();
            $featuredProducts = Product::where('store_id', $eProvider->id)
                                      ->where('featured', true)
                                      ->count();
            $pendingProducts = $totalProducts - $approvedProducts;

            // Get recent orders count (last 30 days)
            $recentOrders = \DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.store_id', $eProvider->id)
                ->where('orders.created_at', '>=', now()->subDays(30))
                ->count();

            // Calculate total revenue (last 30 days)
            $totalRevenue = \DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.store_id', $eProvider->id)
                ->where('orders.created_at', '>=', now()->subDays(30))
                ->where('orders.status', 'completed')
                ->sum(\DB::raw('order_items.quantity * order_items.price'));

            return response()->json([
                'success' => true,
                'data' => [
                    'total_products' => $totalProducts,
                    'approved_products' => $approvedProducts,
                    'pending_products' => $pendingProducts,
                    'featured_products' => $featuredProducts,
                    'recent_orders' => $recentOrders,
                    'total_revenue' => $totalRevenue,
                    'approval_rate' => $totalProducts > 0 ? round(($approvedProducts / $totalProducts) * 100, 2) : 0
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
}
