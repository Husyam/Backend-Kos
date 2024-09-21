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

    //     $revenueData = $this->getRevenueData();
    //     $totalRevenue = $orders->sum('total_cost'); // tambahkan kode ini

    //     return view('pages.order.index', compact('orders', 'revenueData', 'totalRevenue'));
    // }

    public function index(Request $request)
    {

            if (Auth::user()->roles == 'ADMIN') {
                $orders = Order::whereIn('status', ['paid', 'pending'])->paginate(10);
                $totalRevenue = Order::where('status', 'paid')->sum('total_cost');
            } else {
                $orders = Order::whereIn('status', ['paid', 'pending'])
                    ->whereHas('orderItems.product', function ($query) {
                        $query->where('id_user', Auth::id());
                    })
                    ->paginate(10);
                $totalRevenue = Order::where('status', 'paid')
                    ->whereHas('orderItems.product', function ($query) {
                        $query->where('id_user', Auth::id());
                    })
                    ->sum('total_cost');
            }

        // kode lainnya...
        $revenueData = $this->getRevenueData();


        return view('pages.order.index', compact('orders', 'revenueData', 'totalRevenue'));
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

    public function update(Request $request, $id_order)
    {
        $order = Order::findOrFail($id_order);
        $order->update([
            'status' => $request->status,
        ]);

        if ($request->status == 'paid') {
            $this->sendNotificationToUser($order->id_user, 'Order Telah Dibayar dan Status Succes/' . $request->status);
            // $this->sendNotificationToUser($order->first()->id_user, 'Order Dibayar Succes' . $request->status);
        }
        // $this->sendNotificationToUser($order->id_user, 'Order status updated to ' . $request->status);

        return redirect()->route('order.index');
    }

    protected function sendNotificationToUser($id_user, $message,)
    {
        $user = User::findOrFail($id_user);

        //get user by id_user
        // $user = User::where('id_user', $id_user)->first();

        $token = $user->fcm_id;

        $messaging = app('firebase.messaging');
        $notification = Notification::create('Order Dibayar', $message);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        $messaging->send($message);
    }

    public function downloadRekapPdf()
    {

        $owner = auth()->user();

        $orders = Order::with('orderItems.product', 'user.personalData')
            ->when($owner->roles == ('OWNER'), function ($query) use ($owner) {
                $query->whereHas('orderItems.product', function ($query) use ($owner) {
                    $query->where('id_user', $owner->id_user);
                });
            })
        ->get();
        $totalRevenue = $orders->sum('total_cost'); // tambahkan kode ini


        $pdf = PDF::loadView('pages.order.pdf', compact('orders', 'totalRevenue'));
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
