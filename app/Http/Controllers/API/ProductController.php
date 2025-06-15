<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $products = Product::paginate(request('per_page', 10));

            return $this->successResponse($products, 'Products retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve products', 500);
        }
    }

    public function store(ProductRequest $productRequest)
    {
        try {
            DB::beginTransaction();

            $product = Product::create($productRequest->validated());

            DB::commit();

            return $this->successResponse($product, 'Product created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse('Product creation failed', 500);
        }
    }

    public function show(Product $product)
    {
        try {
            return $this->successResponse($product, 'Product retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve product', 500);
        }
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            $product->update($request->validated());

            DB::commit();

            return $this->successResponse($product, 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse('Product update failed', 500);
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            $product->delete();

            DB::commit();

            return $this->successResponse(null, 'Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse('Product deletion failed', 500);
        }
    }
}
