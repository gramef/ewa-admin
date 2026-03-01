<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * Class ProductAPIController
 * @package App\Http\Controllers\API
 */
class ProductAPIController extends Controller
{
    /**
     * Display a listing of public products
     * GET /api/shop/products
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 10);
            $only = $request->get('only');
            $with = $request->get('with', '');
            $myLat = $request->get('myLat');
            $myLon = $request->get('myLon');
            
            $query = Product::where('approved', true)
                ->where('available', true);
            
            // Handle 'with' parameter for relationships
            if ($with) {
                $relationships = explode(',', $with);
                $query->with($relationships);
            }
            
            // Handle 'only' parameter for specific fields
            if ($only) {
                $fields = explode(';', $only);
                $query->select($fields);
            }
            
            // Add location-based sorting if coordinates provided
            if ($myLat && $myLon) {
                // For now, just order by created_at, but you could implement distance calculation
                $query->orderBy('created_at', 'desc');
            } else {
                $query->orderBy('created_at', 'desc');
            }
            
            $products = $query->limit($limit)->get();
            
            return response()->json([
                'success' => true,
                'data' => $products
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
     * Display a specific product
     * GET /api/shop/products/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $product = Product::where('id', $id)
                ->where('approved', true)
                ->where('available', true)
                ->with(['store', 'categories', 'images'])
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
     * Get featured products
     * GET /api/shop/products/featured
     */
    public function featured(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 6);
            $categoryId = $request->get('category_id');
            
            $query = Product::where('approved', true)
                ->where('available', true)
                ->where('featured', true)
                ->with(['store', 'categories']);
                
            if ($categoryId) {
                $query->whereHas('categories', function($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId);
                });
            }
            
            $products = $query->limit($limit)->get();
            
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch featured products',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get popular products
     * GET /api/shop/products/popular
     */
    public function popular(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 6);
            $categoryId = $request->get('category_id');
            
            $query = Product::where('approved', true)
                ->where('available', true)
                ->with(['store', 'categories'])
                ->orderBy('total_orders', 'desc');
                
            if ($categoryId) {
                $query->whereHas('categories', function($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId);
                });
            }
            
            $products = $query->limit($limit)->get();
            
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch popular products',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Search products
     * GET /api/shop/products/search
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = $request->get('q', '');
            $categoryId = $request->get('category_id');
            $limit = $request->get('limit', 20);
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $limit;
            
            $productQuery = Product::where('approved', true)
                ->where('available', true)
                ->with(['store', 'categories']);
                
            if ($query) {
                $productQuery->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                });
            }
            
            if ($categoryId) {
                $productQuery->whereHas('categories', function($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId);
                });
            }
            
            $products = $productQuery->offset($offset)->limit($limit)->get();
            
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search products',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}