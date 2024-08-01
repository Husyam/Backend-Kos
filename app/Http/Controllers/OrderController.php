<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        //get order paginated
        $orders = DB::table('orders')->paginate(10);

        return view('pages.order.index', compact('orders'));
    }

    public function create()
    {
        return view('order.create');
    }

    //show
    public function show($id)
    {
        return view('order.show');
    }

    //edit
    public function edit($id)
    {
        $order = DB::table('orders')->where('id', $id)->first();
        return view('pages.order.edit', compact('order'));
    }

    //update
    public function update(Request $request, $order)
    {
        $order = DB::table('orders')->where('id', $order);
        $order->update([
            'status' => $request->status,

        ]);

        $this->sendNotificationToUser($order->first()->user_id, 'Order status updated to '.$request->status);

       // send notification to user
        //  $this->sendNotificationToUser($order->first()->user_id, 'Order status updated to '.$request->status);

        return redirect()->route('order.index');
    }

    public function sendNotificationToUser($userId, $message){
        $user = User::find($userId);
        $token = $user->fcm_id;

        $messaging = app('firebase.messaging');
        $notification = Notification::create('Order Dibayar', $message);

        $message = CloudMessage::withTarget('token', $token)
        ->withNotification($notification);

        $messaging->send($message);
    }
}
