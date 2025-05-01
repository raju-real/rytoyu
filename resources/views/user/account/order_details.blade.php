@extends('user.layouts.app')
@section('title', $order->invoice ?? $order->order_no ?? '')
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
                    <div class="information-title">Order #{{ $order->invoice ?? $order->order_no ?? '' }}</div>

                    <section class="sec-shopping">
                        <div class="row orders">
                            <div class="col-md-12">
                                @foreach($order->order_products as $item)
                                    <table class="table table-custom table-order">
                                        <thead>
                                        <tr>
                                            <th colspan="3">
                                                <div class="brn-span"><i class="fas fa-laptop-house"></i>{{ $item->product->seller->shop->shop_name ?? siteSettings()['company_name'] ?? '' }}
                                                </div>
                                            </th>
                                            <th><span class="span-s">{{ $item->order_status ?? '' }}</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="image"><a class="media-link" href="{{ route('product-details',$item->product->slug) }}"><i
                                                            class="fa fa-plus"></i><img
                                                            src="{{ asset($item->product->thumbnail_path) }}" height="80" width="100" alt=""/></a></td>

                                            <td class="description">
                                                <h4><a href="{{ route('product-details',$item->product->slug) }}">{{ $item->product->name ?? '' }}</a></h4>
                                                by {{ $item->product->category->name ?? '' }} {{ $item->size ? ', Size: '.$item->size : '' }} and {{ $item->color ? ' Color: '.$item->color : '' }}
                                            </td>
                                            <td class="description"><span><strong>TK:</strong></span>{{ numberFormat($item->item_order_price,2) }}</td>
                                            <td class="description"><span><strong>Qty:</strong></span>{{ $item->quantity ?? 0 }}</td>

                                        </tr>

                                        </tbody>
                                    </table>
                                @endforeach
                            </div>

                        </div>
                    </section>

                </div>
                <!--end main contain of page-->

            </div>
        </div>
    </section>
@endsection

@push('js') @endpush
