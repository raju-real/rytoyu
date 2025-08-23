@extends('user.layouts.app')
@section('title', 'Wishlists')
@push('css')
    <style>
        a.disabled {
            pointer-events: none;
            opacity: 0.6;
        }

        .active-color {
            color: #00b16a !important;
        }
    </style>
@endpush

@section('content')
    <!-- BREADCRUMBS -->
    <section class="page-section breadcrumbs">
        <div class="container">
            <div class="page-header">
                <h1>Wishlists</h1>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('home') }}">Shop</a></li>
                <li class="active">Wishlist Items</li>
            </ul>
        </div>
    </section>
    <!-- /BREADCRUMBS -->
    <!-- PAGE -->

    <section class="page-section color">
        <div class="container">
            @if(count($products) > 0)
                <section class="sec-shopping">
                    <div class="row orders">
                        <div class="col-md-12">
                            @if(Session::has('message'))
                                <p class="alert alert-info">{{ Session::get('message') }}</p>
                            @endif
                            <table class="table table-custom">
                                <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $item)
                                    <tr>
                                        <td class="text-center vert-m">{{ $loop->index + 1 }}</td>
                                        <td class="image">
                                            <a class="media-link" href="#"><i class="fa fa-plus"></i>
                                                <img src="{{ asset($item->product->thumbnail_path) }}" height="100"
                                                     width="100" alt=""/>
                                            </a>
                                        </td>
                                        <td class="description">
                                            <h4>
                                                <a class="active-color"
                                                   href="{{ route('product-details', $item->product->slug) }}">{{ $item->product->name ?? '' }}</a>
                                            </h4>
                                            by <a
                                                href="{{ route('product-lists', ['category' => $item->product->category->slug]) }}">{{ productCategoryNameById($item->product_id) }}</a>
                                        </td>

                                        <td class="total">
                                            TK:
                                            @if($item->product->default_variant->discount_price > 0)
                                                <span
                                                    id="unit-price">{{ numberFormat($item->product->default_variant->discount_price) ?? 0 }}</span>
                                                <span id="discount-price"><del>{{ numberFormat($item->product->default_variant->unit_price) ?? 0 }}</del></span>
                                            @else
                                                <span
                                                    id="unit-price">{{ numberFormat($item->product->default_variant->unit_price) ?? 0 }}</span>
                                            @endif
                                        </td>

                                        <td class="text-center align-middle" style="vertical-align: middle;line-height: 20px;">
                                            <a href="javascript:void(0)" class="add-t-c-2" data-product-id="{{ $item->product->id }}">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a><a href="{{ route('delete-wish-list-item', encrypt_decrypt($item->id,'encrypt')) }}">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>

                            </table>
                        </div>
                    </div>
                </section>
            @else
                <div class="alert alert-danger">No item found!</div>
            @endif
        </div>
    </section>

    <!-- /PAGE -->
@endsection

@push('js')
@endpush
