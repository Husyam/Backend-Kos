@extends('layouts.app')

@section('title', 'Order')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Order</h1>
                <div class="section-header-button">

                    <a href="{{ route('order.downloadRekapPdf') }}" class="btn btn-primary">Download Rekap PDF</a>
                </div>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Order</a></div>

                    <div class="breadcrumb-item">All Order</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('order.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="transaction_number">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Kos Name</th>
                                            <th>Customer</th>
                                            <th>Kos Quantity</th>
                                            <th>Total</th>
                                            <th>Transaction Date</th>
                                            <th>Status</th>
                                            <th>Payment Method</th>
                                            <th>Action</th>
                                        </tr>
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
                                                <td>{{ $orderItem->quantity }} Bulan</td>
                                                <td>{{ $order->total_cost }}</td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>{{ $order->payment_va_name }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('order.edit', $order->id_order) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $orders->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-2">Grafik Pendapatan</h3>
                            <!-- ... other content ... -->
                            <div class="chart-container">
                                <canvas id="revenue-chart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <script>
        const ctx = document.getElementById('revenue-chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [@foreach($orders as $order) '{{ $order->created_at->format('d-m-Y') }}', @endforeach],
                datasets: [{
                    label: 'Pendapatan',
                    data: [@foreach($orders as $order) {{ $order->total_cost }}, @endforeach],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBorderColor: 'rgba(255, 99, 132, 1)',
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
