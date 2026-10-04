@extends('admin.layouts.app')
@section('title', 'Sales Report')
@push('css')
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sales Report</h4>
            </div>
        </div>
    </div>

    <!-- Accordion for Search -->
    <div class="row">
        <div class="col-12">
            <div class="accordion mb-3" id="accordionSearch">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSearch">
                        <button class="accordion-button {{ request()->query() ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseSearch"
                            aria-expanded="{{ request()->query() ? 'true' : 'false' }}" aria-controls="collapseSearch">
                            Search Filters
                        </button>
                    </h2>
                    <div id="collapseSearch" class="accordion-collapse collapse {{ request()->query() ? 'show' : '' }}"
                        aria-labelledby="headingSearch" data-bs-parent="#accordionSearch">
                        <div class="accordion-body">
                            <form action="{{ route('admin.reports.sales') }}" method="GET">
                                <div class="row align-items-end">
                                    <div class="col-md-5 pb-4">
                                        <div class="form-group">
                                            <label class="form-label">Start Date:</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ request('start_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-5 pb-4">
                                        <div class="form-group">
                                            <label class="form-label">End Date:</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ request('end_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-0 mb-4">
                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="text-white">Total Sales</h5>
                    <h3>৳ {{ number_format($totalSales, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="text-white">Total Orders</h5>
                    <h3>{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Order Number</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Order Total</th>
                                    <th>Payment Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td><a
                                                href="{{ route('admin.order-info', $order->unique_id) }}">#{{ $order->order_number }}</a>
                                        </td>
                                        <td>
                                            {{ $order->first_name }} {{ $order->last_name }}<br>
                                            <small>{{ $order->mobile }}</small>
                                        </td>
                                        <td>{{ $order->seller_count ?? 1 }}</td>
                                        <td>৳ {{ number_format($order->total_order_price, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('-', ' ', $order->payment_method)) }}</td>
                                        <td>
                                            @if ($order->order_status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($order->order_status == 'processing')
                                                <span class="badge bg-info">Processing</span>
                                            @elseif($order->order_status == 'complete')
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-danger">Canceled</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <x-no-data-found></x-no-data-found>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {!! $orders->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
