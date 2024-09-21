<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Midtrans\CreateVAService;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class OrderController extends Controller
{
    // function for order
    public function order(Request $request){
        // validate for order
        $request->validate([
            'id_personal_data' => 'required',
            'sub_total' => 'required',
            'total_cost' => 'required',
            'payment_method' => 'required',
            'items' => 'required',
        ]);

        // tentukan shipping cost
        $shippingCost = 8000;

        // hitung sub total
        $subTotal = 0;
        foreach ($request->items as $item) {
            $product = Product::find($item['id_product']);
            $subTotal += $product->price * $item['quantity'];
        }

        // buat order
        $order = Order::create([
            //id_user
            'id_user' => $request->user()->id_user,
            'id_personal_data' => $request->id_personal_data,
            'shipping_cost' => $shippingCost,
            'sub_total' => $subTotal,
            'total_cost' => $subTotal + $shippingCost,
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

        // buat order items
        foreach ($request->items as $item) {
            OrderItem::create([
                // 'order_id' => $order->id_order,
                'id_order' => $order->id_order,
                'id_product' => $item['id_product'],
                'quantity' => $item['quantity'],
            ]);
        }

        // request ke Midtrans
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

    public function getOrderById($id) {
        $order = Order::with('orderItems.product')->find($id);
        //load user and personal data
        $order->load('user', 'personalData');

        return response()->json([
            // 'status' => 'success',
            'order' => $order,
        ]);
    }

    //function for check order status
    public function checkOrderStatus($id_order){
        $order = Order::find($id_order);

        return response()->json([
            // 'status' => 'success',
            'status' => $order->status,
        ]);
    }

    public function getOrderByUser(Request $request){
        $orders = Order::where('id_user', $request->user()->id_user)->get();

        return response()->json([
            // 'status' => 'success',
            'orders' => $orders,
        ]);
    }

}
