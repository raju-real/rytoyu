@extends('user.layouts.app')
@section('title', 'Order List')
@push('css')
@endpush

@section('content')
    <section class="page-section">
        <div class="wrap container">
            <div class="row">
                <!--start sidebar-->
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="widget account-details">
                        <h2 class="widget-title">Account</h2>
                        @include('user.account.menus')
                    </div>
                </div>
                <!--end sidebar-->
                <!--start main contain of page-->
                <div class="col-lg-9 col-md-9 col-sm-8">
                    <div class="information-title">Order List</div>
                    @if (request('message'))
                        <div class="alert alert-success">
                            {{ request('message') }}
                        </div>
                    @endif
                    @if (session()->has('message'))
                        <div class="alert alert-{{ session()->get('type') }}">
                            <span class="font-weight-500">{{ session()->get('message') }}</span>
                        </div>
                    @endif
                    <div class="search-product">
                        <span><i class="fas fa-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') ?? '' }}"
                            placeholder="Search by Invoice, Mobile" id="searchOrder">
                    </div>

                    <section class="sec-shopping">
                        <div class="row orders">
                            <div class="col-md-12">
                                @if (count($orders))
                                    @foreach ($orders as $order)
                                        <table class="table table-custom table-order">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">
                                                        <div class="brn-span"><i class="fas fa-file-invoice"></i>#
                                                            <a target="_blank"
                                                                href="{{ route('user-order-invoice', $order->unique_id) }}">{{ $order->invoice ?? ($order->order_number ?? '') }}</a>
                                                        </div>
                                                    </th>
                                                    <th><a href="{{ route('order-details', $order->unique_id) }}"
                                                            class="span-s">Details</a>
                                                        {{--                                                        <a href="{{ route('sslcommerz.pay-now', ['unique_id' => $order->unique_id]) }}" --}}
                                                        {{--                                                            class="span-s">Pay Now</a> --}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="description">
                                                        <span class="font-weight-500">Order Date:
                                                            {{ dateFormat($order->created_at, 'd, M y') }}</span>
                                                    </td>
                                                    <td class="description">
                                                        <span><strong>TK:
                                                            </strong></span>{{ numberFormat($order->total_order_price, 2) ?? 0 }}
                                                    </td>
                                                    <td class="description">
                                                        <span><strong>Items:
                                                            </strong></span>{{ $order->order_products->count() ?? 0 }}
                                                    </td>
                                                    <td class="description">
                                                        <span><strong>Status: </strong></span>
                                                        <span
                                                            class="badge badge-primary">{{ ucfirst($order->order_status) }}</span>
                                                    </td>
                                                    <td class="description">
                                                        <span><strong>Payment: </strong></span>
                                                        @if ($order->payment_status == 'paid')
                                                            <span class="badge badge-success"
                                                                style="background:#28a745; color:white; padding: 4px 8px; border-radius: 4px;">Paid</span>
                                                        @else
                                                            <span class="badge badge-warning"
                                                                style="background:#ffc107; color:black; padding: 4px 8px; border-radius: 4px;">{{ ucfirst($order->payment_status ?? 'Unpaid') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    @endforeach
                                @else
                                    <x-no-data-found></x-no-data-found>
                                @endif
                            </div>
                            {!! $orders->links() !!}
                        </div>
                    </section>
                </div>
                <!--end main contain of page-->
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('assets/user/js/order_list.js') }}"></script>
@endpush
