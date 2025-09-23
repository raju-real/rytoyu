@extends('admin.layouts.app')
@section('title', 'Manage Orders')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Manage Orders</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Accordion for Search -->
            <div class="accordion mb-3" id="accordionSearch">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSearch">
                        <button class="accordion-button {{ request()->query() ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseSearch"
                                aria-expanded="{{ request()->query() ? 'true' : 'false' }}"
                                aria-controls="collapseSearch">
                            Search
                        </button>
                    </h2>
                    <div id="collapseSearch" class="accordion-collapse collapse {{ request()->query() ? 'show' : '' }}"
                         aria-labelledby="headingSearch" data-bs-parent="#accordionSearch">
                        <div class="accordion-body">
                            <form method="GET" action="{{ route('admin.manage-orders') }}">
                                <div class="row">
                                    <div class="col-md-6 pb-4">
                                        <div class="form-group">
                                            <input type="search" name="search" class="form-control"
                                                   placeholder="Search by Order Number, Invoice, Mobile"
                                                   value="{{ request('search') ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4 pb-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="order_date" class="form-control datepicker"
                                                       value="{{ request('order_date') ?? '' }}"
                                                       placeholder="Order Date"
                                                       autocomplete="off" autofocus >
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-calendar"></i> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mt-0">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            class="table table-striped table-bordered table-md mb-0 text-nowrap text-center align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Sl.no</th>
                                <th>Order Date</th>
                                <th>Invoice</th>
                                <th>Item Total</th>
                                <th>Shipping Fee</th>
                                <th>Order Amount</th>
                                <th>Commission</th>
                                <th>Seller Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ dateFormat($order->created_at, 'd M, y') }}</td>
                                    <td>
                                        <a target="_blank"
                                           href="{{ route('admin.order-invoice', $order->order->unique_id) }}">{{ $order->invoice ?? '' }}</a>
                                    </td>
                                    <td>{{ numberFormat($order->order_amount, 2) }}</td>
                                    <td>(+) {{ $order->shipping_fee ?? '' }}</td>
                                    <td>{{ numberFormat($order->order_price, 2) }}</td>
                                    <td>(-) {{ numberFormat($order->total_commission, 2) }}</td>
                                    <td>{{ numberFormat($order->seller_amount, 2) }}</td>
                                    <td>
                                        <a type="button" class="btn btn-sm btn-info show-order-products"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           title="Order Info"
                                           data-id="{{ $order->order->unique_id }}">
                                            <i class="fa fa-eye fa-xl"></i>
                                        </a>
                                        <a href="{{ route('admin.order-summary',$order->order->unique_id) }}"
                                           class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="Show Details">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        <a href="{{ route('admin.change-order-status',$order->order->unique_id) }}"
                                           class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="Change Status">
                                            <i class="fa fa-highlighter"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <x-no-data-found></x-no-data-found>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {!! $orders->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/seller_orders.js') }}"></script>
@endpush
