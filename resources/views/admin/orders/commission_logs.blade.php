@extends('admin.layouts.app')
@section('title', 'Commission Logs')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Commission Logs</h4>
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
                            aria-expanded="{{ request()->query() ? 'true' : 'false' }}" aria-controls="collapseSearch">
                            Search
                        </button>
                    </h2>
                    <div id="collapseSearch" class="accordion-collapse collapse {{ request()->query() ? 'show' : '' }}"
                        aria-labelledby="headingSearch" data-bs-parent="#accordionSearch">
                        <div class="accordion-body">
                            <form method="GET" action="{{ route('admin.commission-logs') }}">
                                <div class="row">
                                    <div class="col-md-4 pb-4">
                                        <div class="form-group">
                                            <input type="search" name="search" class="form-control"
                                                placeholder="Search by Order Number,Invoice"
                                                value="{{ request('search') ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <select name="seller" class="form-select" id="seller">
                                                <option value="" {{ !isset(request()->seller) ? 'selected' : '' }}>
                                                    Seller
                                                </option>
                                                @foreach (allSellers() as $seller)
                                                    <option value="{{ $seller->code }}"
                                                        {{ request('seller') === $seller->code ? 'selected' : '' }}>
                                                        {{ $seller->name }} ({{ $seller->shop->shop_name ?? '' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
{{--                                    <div class="col-md-4">--}}
{{--                                        <div class="form-group mb-3">--}}
{{--                                            <select name="pay_to" class="form-select">--}}
{{--                                                <option value="{{ !isset(request()->pay_to) ? 'selected' : '' }}">--}}
{{--                                                    Payment To</option>--}}
{{--                                                @foreach (getPayToList() as $pay_to)--}}
{{--                                                    <option value="{{ $pay_to->value }}"--}}
{{--                                                        {{ request('pay_to') === $pay_to->value ? 'selected' : '' }}>--}}
{{--                                                        {{ $pay_to->title }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <select name="payment_status" class="form-select">
                                                <option value=""
                                                    {{ !isset(request()->payment_status) ? 'selected' : '' }}>
                                                    Payment Status</option>
                                                @foreach (getPaymentStatus() as $status)
                                                    <option value="{{ $status->value }}"
                                                        {{ request('status') === $status->value ? 'selected' : '' }}>
                                                        {{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 pb-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="search" name="order_date" class="form-control datepicker"
                                                    value="{{ request('order_date') ?? '' }}" placeholder="Order Date"
                                                    autocomplete="off">
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
                        <table class="table table-striped table-bordered table-md mb-0 text-nowrap text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Seller</th>
                                    <th>Order Date</th>
                                    <th>Order Amount</th>
                                    <th>C Rate</th>
                                    <th>Commission</th>
                                    <th>Seller Amount</th>
{{--                                    <th>Pay To</th>--}}
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)

                                    @foreach ($order->seller_order_logs as $index => $log)
                                        <tr>
                                            @if ($index === 0)
                                                <td rowspan="{{ $order->seller_count }}" class="text-center align-middle">
                                                    <a href="javascript:void(0)" class="show-order-products"
                                                        data-id="{{ $order->unique_id }}">
                                                        {{ $order->order_number ?? '' }}
                                                    </a><br>
                                                    {{ $order->invoice ?? '' }}
                                                </td>
                                            @endif
                                            <td>
                                                <a href="javascript:void(0)" class="show-seller-info"
                                                    data-seller-code="{{ $log->seller->code }}">
                                                    {{ $log->seller->shop->shop_name ?? '' }}
                                                </a>
                                                <br>
                                                <strong>
                                                    {{ $log->seller->shop->mobile ?? ($log->seller->mobile ?? ($log->seller->shop->phone ?? '')) }}
                                                </strong>
                                            </td>
                                            <td class="align-middle">{{ dateFormat($log->created_at, 'd M, y') }}</td>

                                            {{-- Financial Info --}}
                                            <td class="align-middle">{{ numberFormat($log->order_amount, 2) }}</td>
                                            <td class="align-middle">{{ $log->commission_rate ?? 0 }} %</td>
                                            <td class="align-middle">{{ numberFormat($log->total_commission ?? 0, 2) }}</td>
                                            <td class="align-middle">{{ numberFormat($log->seller_amount ?? 0, 2) }}</td>
{{--                                            <td class="align-middle">{{ ucFirst($log->pay_to ?? '') }}</td>--}}
                                            <td class="align-middle">{{ ucFirst($log->payment_status ?? '') }}</td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <x-no-data-found />
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
    <script src="{{ asset('assets/admin/js/custom/manage_orders.js') }}"></script>
@endpush
