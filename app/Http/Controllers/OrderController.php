<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:ADMIN,OWNER');
    }

    // public function index(Request $request)
    // {
    //     $orders = Order::with('user.personalData')
    //         ->when(Auth::user()->roles == 'OWNER', function($query) {
    //             return $query->whereHas('orderItems.product', function ($query) {
    //                 $query->where('user_id', Auth::id());
    //             });
    //         })
    //         ->latest()
    //         ->paginate(10);

    //     return view('pages.order.index', compact('orders'));
    // }
    public function index(Request $request)
    {
        $orders = Order::with('user.personalData')
            ->when(Auth::user()->roles == 'OWNER', function($query) {
                return $query->whereHas('orderItems.product', function ($query) {
                    $query->where('user_id', Auth::id());
                });
            })
            ->latest()
            ->paginate(10);

        $revenueData = $this->getRevenueData();

        return view('pages.order.index', compact('orders', 'revenueData'));
    }

    public function create()
    {
        return view('order.create');
    }

    public function show($id)
    {
        return view('order.show');
    }

    public function edit($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('pages.order.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
        ]);

        $this->sendNotificationToUser($order->user_id, 'Order status updated to ' . $request->status);

        return redirect()->route('order.index');
    }

    protected function sendNotificationToUser($userId, $message)
    {
        $user = User::findOrFail($userId);
        $token = $user->fcm_id;

        $messaging = app('firebase.messaging');
        $notification = Notification::create('Order Dibayar', $message);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        $messaging->send($message);
    }

    public function downloadRekapPdf()
    {
        //saya ingin yang mendownload rekap ini yaitu owner dari pemilik produk tersebut bukan user yang order produk tersebut, kemudian admin juga bisa mendownload rekap tersebut untuk melihat semua orderan yang masuk
        // $owner = auth()->user();
        // $orders = Order::with('orderItems.product', 'user.personalData')
        //     ->when($owner->roles == 'OWNER', function ($query) use ($owner) {
        //         return $query->whereHas('orderItems.product', function ($query) use ($owner) {
        //             $query->where('user_id', $owner->id);
        //         });
        //     })
        //     ->get();
        // $pdf = PDF::loadView('pages.order.pdf', compact('orders'));
        // return $pdf->download('rekap-pesanan.pdf');

        $owner = auth()->user();

        $orders = Order::with('orderItems.product', 'user.personalData')
            ->when($owner->roles == ('OWNER'), function ($query) use ($owner) {
                $query->whereHas('orderItems.product', function ($query) use ($owner) {
                    $query->where('user_id', $owner->id);
                });
            })
            ->get();

        $pdf = PDF::loadView('pages.order.pdf', compact('orders'));
        return $pdf->download('rekap-pesanan.pdf');


    }

    public function getRevenueData()
    {
        $paidOrders = Order::where('status', 'paid')->get();
        $revenueData = [];

        foreach ($paidOrders as $order) {
            $revenueData[] = [
                'date' => $order->created_at->format('Y-m-d'),
                'revenue' => $order->total_cost,
            ];
        }

        return $revenueData;
    }


}
