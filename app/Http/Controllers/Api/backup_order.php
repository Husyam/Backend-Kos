<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Midtrans\CreateVAService;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //function for order
    public function order(Request $request){
       // validate for order
        $request->validate([
            'personal_data_id' => 'required',
            //shipping cost
            'shipping_cost' => 'required',
            'sub_total' => 'required',
            'total_cost' => 'required',
            'payment_method' => 'required',
            'items' => 'required',
        ]);



        //sub total
        $subTotal = 0;
        foreach ($request->items as $item) {
            //get product price
            $product = Product::find($item['product_id']);
            $subTotal += $product->price * $item['quantity'];
        }

        //create order
        $order = Order::create([
            'user_id' => $request->user()->id,
            'personal_data_id' => $request->personal_data_id,
            'shipping_cost' => $request->shipping_cost,
            'sub_total' => $subTotal,
            'total_cost' => $subTotal + $request->shipping_cost,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'transaction_number' => 'TRX'.rand(1000,9999),
        ]);

        if($request->payment_va_name){
            $order->update([
                'payment_va_name' => $request->payment_va_name,
                // 'payment_va_number' => $request->payment_va_number,
            ]);
        }

        //create order items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        // //request midtrans
        $midtrans = new CreateVAService($order->load('user', 'orderItems'));
        $apiResponse = $midtrans->getVA();
        $order->payment_va_number = $apiResponse->va_numbers[0]->va_number;
        $order->save();

        return response()->json([
            'status' => 'success',
            'order' => $order,
            'message' => 'Order berhasil disimpan'
        ]);
    }
}
