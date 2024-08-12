@extends('pages.layouts.head')

@section('content')
    <h2 class="text-center my-4">Rekap Order</h2>
    <div class="mx-auto" style="margin: 0 20; margin-left: 20px;"> <!-- add this div -->
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Kos Name</th>
                    <th>Customer</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Transaction Date</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>
                            @foreach ($order->orderItems as $orderItem)
                                {{ $orderItem->product->name }}
                                @if (!$loop->last)
                                ,
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $order->user->personalData->name }} ({{ $order->user->name }})</td>
                        <td>
                            @foreach ($order->orderItems as $orderItem)
                                {{ $orderItem->quantity }} bulan
                                @if (!$loop->last)
                                ,
                                @endif
                            @endforeach
                        </td>
                        <td>{{ number_format($order->total_cost, 2) }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $order->payment_va_name }}</td>
                        <td>
                            <span class="badge
                                @if($order->status == 'paid') badge-success
                                @elseif($order->status == 'pending') badge-warning
                                @else badge-danger
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- close the div -->
@endsection
