@extends('user.layouts.app')
@section('title',$heading_title ?? 'All PRODUCTS')
@push('css') @endpush

@section('content')
    <!-- BREADCRUMBS -->
    <section class="page-section breadcrumbs">
        <div class="container">
            <div class="page-header">
                <h1>{{ $heading_title ?? 'All PRODUCTS' }}</h1>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">{{ $heading_title ?? 'All PRODUCTS' }}</li>
            </ul>
        </div>
    </section>
    <!-- /BREADCRUMBS -->
    <!-- PAGE WITH SIDEBAR -->
    <section class="page-section with-sidebar mt-40">
        <div class="container">
            <div class="row">
                <!-- SIDEBAR -->
                <aside class="col-md-3 sidebar" id="sidebar">
                    <!-- widget search -->
                    <div class="widget ">
                        <div class="widget-search">
                            <input class="form-control" type="text" placeholder="Search" id="products-search">
                            <button><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <!-- /widget search -->
                    <!-- widget shop categories -->
                    <div class="widget shop-categories mt-10">
                        <h4 class="widget-title">Categories</h4>
                        <div class="widget-content">
                            <ul>
                                @foreach(getActiveCategories() as $category)
                                    <li>
                                        <a href="{{ route('product-lists',['category' => $category->slug]) }}"
                                           class="orange-text"><strong>{{ $category->name ?? '' }}</strong></a>
                                        @if(count(getActiveSubCategories($category->id)))
                                            <ul class="children">
                                                @foreach(getActiveSubCategories($category->id) as $subcategory)
                                                    <li>
                                                        <a href="{{ route('product-lists',['subcategory' => $subcategory->slug]) }}">{{ $subcategory->name ?? '' }}
                                                            <span
                                                                class="count">{{  productCountBySubCategory($subcategory->id) }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- /widget shop categories -->
                    <!-- widget  product filter -->
                    <div class="widget shop-categories mt-10 p-filter pb-10">
                        <h4>Filter by price</h4>
                        {{--                        <p class="range-filter">--}}
                        {{--                            <label for="amount">Price:</label>--}}
                        {{--                            TK:--}}
                        {{--                            <input class="amount" id="amount_min" type="text">--}}
                        {{--                            <span> -</span> TK:--}}
                        {{--                            <input class="amount" id="amount_max" type="text">--}}
                        {{--                        </p>--}}

                        <input class="amount range-filter" id="amount_min" type="number" placeholder="From"
                               value="{{ request('amount_min') }}">
                        <br>
                        <input class="amount range-filter" id="amount_max" type="number" placeholder="To"
                               value="{{ request('amount_max') }}">


                        <div id="slider-range"
                             class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                            <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                        </div>
                    </div>
                    <div class="widget shop-categories mt-10">
                        <h4 class="widget-title orange-text">Brands</h4>
                        <div class="widget-content">
                            <ul>
                                @foreach(getBrands() as $brand)
                                    {{--                                    <li>--}}
                                    {{--                                        @php--}}
                                    {{--                                            $query = request()->query();--}}
                                    {{--                                            $query['brand'] = $brand->slug;--}}
                                    {{--                                        @endphp--}}

                                    {{--                                        <a href="{{ route('product-lists', $query) }}">--}}
                                    {{--                                            <strong>{{ $brand->name ?? '' }}</strong>--}}
                                    {{--                                        </a>--}}
                                    {{--                                    </li>--}}
                                    <li>
                                        <a href="{{ route('product-lists', ['brand' => $brand->slug]) }}">
                                            <strong>{{ $brand->name ?? '' }}</strong>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- /widget product price -->
                    <!-- widget  BRAND -->
                    {{--                    <div class="widget shop-categories mt-10 p-filter">--}}
                    {{--                        <h4>BRAND</h4>--}}
                    {{--                        <div class="bran-radio">--}}
                    {{--                            <div class="radio">--}}
                    {{--                                @foreach(getBrands() as $brand)--}}
                    {{--                                    <div>--}}
                    {{--                                        <input id="radio-{{ $brand->id }}" class="radio-custom" name="radio-group"--}}
                    {{--                                               type="checkbox" checked>--}}
                    {{--                                        <label for="radio-{{ $brand->id }}"--}}
                    {{--                                               class="radio-custom-label">{{ $brand->name ?? '' }}</label>--}}
                    {{--                                    </div>--}}
                    {{--                                @endforeach--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <!-- /widget BRAND -->
                    <!-- widget  BRAND -->
                    {{--                    <div class="widget shop-categories mt-10 p-filter">--}}
                    {{--                        <h4>STOCK STATUS</h4>--}}
                    {{--                        <div class="bran-radio">--}}
                    {{--                            <div class="radio">--}}
                    {{--                                <div>--}}
                    {{--                                    <input id="radio-a" class="radio-custom" name="radio-group" type="radio">--}}
                    {{--                                    <label for="radio-a" class="radio-custom-label">YES</label>--}}
                    {{--                                </div>--}}
                    {{--                                <div>--}}
                    {{--                                    <input id="radio-b" class="radio-custom" name="radio-group" type="radio">--}}
                    {{--                                    <label for="radio-b" class="radio-custom-label">NO</label>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="widget shop-categories mt-10">
                        <h4 class="widget-title orange-text">STOCK STATUS</h4>
                        <div class="widget-content">
                            @php
                                $queryYes = request()->query();
                                $queryYes['stock-status'] = 'YES';

                                $queryNo = request()->query();
                                $queryNo['stock-status'] = 'NO';
                            @endphp
                            <ul>
                                <li>
                                    <a href="{{ route('product-lists', $queryYes) }}">
                                        <strong>YES</strong>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('product-lists', $queryNo) }}">
                                        <strong>NO</strong>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /widget BRAND -->
                </aside>
                <!-- /SIDEBAR -->
                <!-- CONTENT -->
                <div class="col-md-9 content">
                    @if(isset($banner_images) && count($banner_images))
                        <div class="main-slider sub">
                            <div class="owl-carousel" id="main-slider">
                                @foreach($banner_images as $key => $image)
                                    @if(file_exists($image))
                                        <div class="item slide{{ $key }} sub">
                                            <img class="slide-img slide-i-{{ $key }}" src="{{ asset($image) }}" alt=""/>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <!-- shop-sorting -->
                    <div class="shop-sorting">
                        <div class="row">
                            <div class="col-sm-3 text-left-sm">
                                <a class="btn btn-theme btn-theme-transparent btn-theme-sm grid-style" href="#"><i
                                        class="fa-solid fa-bars"></i></a>
                                {{--                                 <a class="btn btn-theme btn-theme-transparent btn-theme-sm grid-style2" href="#"><i class="fa-solid fa-list"></i></a>--}}
                            </div>
                            <div class="col-sm-9">
                                <div class="radio price-p">
                                    <div class="price-block">
                                        <input
                                            id="radio-c"
                                            class="radio-custom price-filter"
                                            name="price-range"
                                            type="checkbox"
                                            value="500"
                                            {{ request('amount_max') == '500' ? 'checked' : '' }}>
                                        <label for="radio-c" class="radio-custom-label">Less than: 500</label>
                                    </div>
                                    <div class="price-block">
                                        <input
                                            id="radio-d"
                                            class="radio-custom price-filter"
                                            name="price-range"
                                            type="checkbox"
                                            value="1500"
                                            {{ request('amount_max') == '1500' ? 'checked' : '' }}>
                                        <label for="radio-d" class="radio-custom-label">Less than: 1,500</label>
                                    </div>

                                    <div class="price-block">
                                        <input
                                            id="radio-e"
                                            class="radio-custom category-filter"
                                            name="price-range"
                                            type="checkbox"
                                            data-category="women">
                                        <label for="radio-e" class="radio-custom-label">Women</label>
                                    </div>
                                    <div class="price-block">
                                        <input
                                            id="radio-f"
                                            class="radio-custom category-filter"
                                            name="price-range"
                                            type="checkbox"
                                            data-category="men">
                                        <label for="radio-f" class="radio-custom-label">Men</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /shop-sorting -->
                    <!-- Products grid -->
                    <div class="row products grid">
                        @foreach($products as $product)
                            <div class="col-md-4 cate-p">
                                <div class="thumbnail no-border no-padding">
                                    <div class="media">
                                        <img class="img-sl" src="{{ asset($product->thumbnail_path) }}" alt=""/>
                                        <button class="btn orange-bg view-btn product-view"
                                                data-product-id="{{ $product->id }}"><i
                                                class="fa-regular fa-eye"></i></button>
                                    </div>
                                    <div class="caption text-center">
                                        <h4 class="caption-title"><a
                                                href="{{ route('product-details',$product->slug) }}">{{ $product->name ?? '' }}</a>
                                        </h4>
                                        <p class="p-title">{{ $product->brand->name ?? '' }}</p>
                                        @if($product->discount_price > 0)
                                            <div class="price">
                                                <ins>TK: {{ $product->discount_price }}</ins>
                                                <del>TK: {{ $product->unit_price }}</del>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>TK: {{ $product->unit_price }}</ins>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- end Related Products  -->
                    </div>
                    <!-- /Products grid -->
                    <!-- Pagination -->
                    <div class="pagination-wrapper text-center">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                    <!-- /Pagination -->
                </div>
                <!-- /CONTENT -->
            </div>
        </div>
    </section>
    <!-- /PAGE WITH SIDEBAR -->
    <!-- end become a partner -->
    <div class="clearfix"></div>
@endsection

@push('js')
    <script src="{{ asset('assets/user/js/products_page.js') }}"></script>
@endpush
