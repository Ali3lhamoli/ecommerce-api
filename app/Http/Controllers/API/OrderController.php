<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $user = Auth::user();

            $orders = Order::with('orderItems.product')
                ->where('user_id', $user->id)
                ->paginate(request('per_page', 10));

            return $this->successResponse($orders, 'Orders retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve orders', 500);
        }
    }

    public function show(Order $order)
    {
        try {
            $order->load('orderItems.product');

            return $this->successResponse($order, 'Order retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve order', 500);
        }
    }

    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $items = $request->input('items');
            $totalAmount = 0;

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    return $this->errorResponse("Insufficient stock for product: {$product->name}", 422);
                }

                $totalAmount += $product->price * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return $this->successResponse(
                $order->load('orderItems.product'),
                'Order created successfully',
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse(
                'Order creation failed',
                500,
                app()->isLocal() ? ['exception' => $e->getMessage()] : null
            );
        }
    }
}
