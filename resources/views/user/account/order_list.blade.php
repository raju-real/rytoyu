@extends('user.layouts.app')
@section('title','Order List')
@push('css') @endpush

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
                    @if(request('message'))
                        <div class="alert alert-success">
                            {{ request('message') }}
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
                                @foreach($orders as $order)
                                    <table class="table table-custom table-order">
                                        <thead>
                                        <tr>
                                            <th colspan="3">
                                                <div class="brn-span"><i
                                                        class="fas fa-file-invoice"></i># {{ $order->invoice ?? $order->order_number ?? '' }}
                                                </div>
                                            </th>
                                            <th><a href="{{ route('order-details',$order->unique_id) }}" class="span-s">Details</a>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="description">
                                                <h4>Order Date: {{ dateFormat($order->created_at,'d, M y') }}</h4>
                                            </td>
                                            <td class="description">
                                                <span><strong>TK: </strong></span>{{ numberFormat($order->total_order_price,2) ?? 0 }}
                                            </td>
                                            <td class="description">
                                                <span><strong>Items: </strong></span>{{ $order->order_products->count() ?? 0 }}
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                @endforeach
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
