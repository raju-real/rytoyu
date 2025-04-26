@extends('user.layouts.app')
@section('title','Home')
@push('css') @endpush

@section('content')
    <!-- PAGE -->
    <section class="page-section no-padding slider slider-banner">
        <div class="container full-width">
            <div class="main-slider">
                <div class="owl-carousel" id="main-slider">
                    <!-- Slide item -->
                    @foreach(activeSliders() as $slider)
                        <div class="item slide1">
                            <img class="slide-img" src="{{ asset($slider->image_path) }}" alt=""/>
                            <div class="caption">
                                <div class="container">
                                    <div class="div-table">
                                        <div class="div-cell">
                                            <div class="caption-content">
                                                <h2 class="caption-title">{{ $slider->title ?? '' }}</h2>
                                                <h3 class="caption-subtitle">{{ $slider->highlighted_title ?? '' }} </h3>
                                                <h5 class="sale-p">{{ $slider->caption ?? '' }}
                                                    <label class="orange-text">
                                                        {{ $slider->highlighted_caption ?? '' }}
                                                        <span>
                                                            <img src="{{ asset('assets/user/img/border.png') }}"
                                                                 alt="img">
                                                         </span>
                                                    </label>
                                                </h5>
                                                <p class="caption-text">
                                                    <a class="btn btn-theme"
                                                       href="#">{{ $slider->button_name ?? '' }}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if(count(latestAnnouncements()))
            <div class="notification-offer">
                <marquee behavior="scroll" direction="right" scrollamount="3">
                    <ul class="ul-m">
                        @foreach(latestAnnouncements() as $announcement)
                            <li>{{ $announcement->title ?? '' }}
                                <strong>{{ $announcement->highlighted_title ?? '' }}</strong></li>
                        @endforeach
                    </ul>
                </marquee>
            </div>
        @endif
        <div>
        </div>
    </section>
    <!-- /PAGE -->
    <!-- New in -->
    <section class="page-section col-md-12 p-0">
        <div class="container-fluid p-0">
            <h2 class="section-title"><span>New in</span></h2>
            <p class="text-center p-destails">Because the best looks don't wait. Discover the latest arrivals.</p>
            <div class="top-products-carousel">
                <div class="owl-carousel slider-c-custom" id="top-products-carouselt">
                    @foreach(getNewInProducts() as $product)
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
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- end new in -->
    <!-- edit  -->
    <section class="edit-area col-md-12 p-0">
        <div class="container">
            <div class="col-md-12 text-center">
                <h2 class="section-title"><span>Edits</span></h2>
                <p class="text-center p-destails">Curated collection for every vibe. Find your perfect fit for any
                    occasion.</p>
            </div>
        </div>
        <div class="edit-list">
            <div class="edit-block">
                <img src="assets/user/img/edit1.png" alt="img">
                <div class="edit-details">
                    <h3>Basics</h3>
                    <div class="btn-row">
                        <button class="btn btn-shop orange-bg">SHOP WOMEN</button>
                        <button class="btn btn-shop orange-bg">SHOP MEN</button>
                    </div>
                </div>
            </div>
            <div class="edit-block">
                <img src="assets/user/img/edit2.png" alt="img">
                <div class="edit-details">
                    <h3>Casual Wear</h3>
                    <div class="btn-row">
                        <button class="btn btn-shop orange-bg">SHOP WOMEN</button>
                        <button class="btn btn-shop orange-bg">SHOP MEN</button>
                    </div>
                </div>
            </div>
            <div class="edit-block">
                <img src="assets/user/img/edit3.png" alt="img">
                <div class="edit-details">
                    <h3>Office Wear</h3>
                    <div class="btn-row">
                        <button class="btn btn-shop orange-bg">SHOP WOMEN</button>
                        <button class="btn btn-shop orange-bg">SHOP MEN</button>
                    </div>
                </div>
            </div>
            <div class="edit-block">
                <img src="assets/user/img/edit4.png" alt="img">
                <div class="edit-details">
                    <h3>Traditional</h3>
                    <div class="btn-row">
                        <button class="btn btn-shop orange-bg">SHOP WOMEN</button>
                        <button class="btn btn-shop orange-bg">SHOP MEN</button>
                    </div>
                </div>
            </div>
            <div class="edit-block">
                <img src="assets/user/img/edit5.png" alt="img">
                <div class="edit-details">
                    <h3>Pants</h3>
                    <div class="btn-row">
                        <button class="btn btn-shop orange-bg">SHOP WOMEN</button>
                        <button class="btn btn-shop orange-bg">SHOP MEN</button>
                    </div>
                </div>
            </div>
            <div class="edit-block">
                <img src="assets/user/img/edit6.png" alt="img">
                <div class="edit-details">
                    <h3>Footwear</h3>
                    <div class="btn-row">
                        <button class="btn btn-shop orange-bg">SHOP WOMEN</button>
                        <button class="btn btn-shop orange-bg">SHOP MEN</button>
                    </div>
                </div>
            </div>
            <div class="edit-block">
                <img src="assets/user/img/edit7.png" alt="img">
                <div class="edit-details">
                    <h3>Jewelry</h3>
                    <div class="btn-row">
                        <button class="btn btn-shop orange-bg">SHOP WOMEN</button>
                        <button class="btn btn-shop orange-bg">SHOP MEN</button>
                    </div>
                </div>
            </div>
            <div class="edit-block">
                <img src="assets/user/img/edit8.png" alt="img">
                <div class="edit-details">
                    <h3>Accessories</h3>
                    <div class="btn-row">
                        <button class="btn btn-shop orange-bg">SHOP WOMEN</button>
                        <button class="btn btn-shop orange-bg">SHOP MEN</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end edit -->
    <!--Brands -->
    <section class="page-section  col-md-12 p-0">
        <div class="container-fluid p-0">
            <h2 class="section-title"><span>Brands </span></h2>
            <p class="text-center p-destails">From timeless classics to trendsetters, explore the brands that define
                style.</p>
            <div class="top-products-carousel">
                <div class="owl-carousel slider-c-custom" id="top-products-carouselb">
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/b1.png" alt=""/>
                        </div>
                        <img src="assets/user/img/brandl.png" class="brand-logo">
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/b2.png" alt=""/>
                        </div>
                        <img src="assets/user/img/brandl1.png" class="brand-logo">
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/b3.png" alt=""/>
                        </div>
                        <img src="assets/user/img/brandl2.png" class="brand-logo">
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/b4.png" alt=""/>
                        </div>
                        <img src="assets/user/img/brandl4.png" class="brand-logo">
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/b3.png" alt=""/>
                        </div>
                        <img src="assets/user/img/brandl1.png" class="brand-logo">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end Latest offers -->
    <!-- Latest offers -->
    <section class="page-section  col-md-12 p-0">
        <div class="container-fluid p-0">
            <h2 class="section-title"><span>Latest offers </span></h2>
            <p class="text-center p-destails">Style steals you can't miss!</p>
            <div class="top-products-carousel">
                <div class="owl-carousel slider-c-custom" id="top-products-carousel">
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/l1.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a>
                            </h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/l2.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a>
                            </h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/s5.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a>
                            </h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/l3.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a>
                            </h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/s3.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a>
                            </h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end Latest offers -->
    <!-- Just for you -->
    <section class="page-section  col-md-12 p-0">
        <div class="container-fluid p-0">
            <h2 class="section-title"><span>Just for you  </span></h2>
            <p class="text-center p-destails">Your wardrobe upgrade starts here.</p>
            <div class="top-products-carousel">
                <div class="owl-carousel slider-c-custom" id="top-products-carouselj">
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/j1.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a>
                            </h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/j2.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a>
                            </h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/j3.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a>
                            </h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/j4.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a>
                            </h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/s3.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a>
                            </h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.000</ins>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end Just for you -->
    <!-- become a partner -->
    <section class="offter-block-list">
        <div class="row m-0">
            <div class="col-md-4 p-0">
                <div class="alll-offer-list bg-gray">
                    <div class="icon-offer"><img src="assets/user/img/off1.svg" alt="icon"></div>
                    <div class="offer-details">
                        <p>
                            <strong>Sing up to receive special offers:</strong>
                            Unlock exclusive deals and the latest trends.</p>
                        <button class="btn orange-bg"><span>Join Now</span></button>
                    </div>
                    <img class="shape" src="assets/user/img/shape.svg" alt="">
                </div>
            </div>
            <div class="col-md-4 p-0">
                <div class="alll-offer-list bg-gray">
                    <div class="icon-offer"><img src="assets/user/img/off2.svg" alt="icon"></div>
                    <div class="offer-details">
                        <p>
                            <strong>Become a partner: </strong>
                            Grow your brand with us and reach fashion lovers across Bangladesh.
                        </p>
                        <button class="btn orange-bg"><span>Apply</span></button>
                    </div>
                    <img class="shape" src="assets/user/img/shape.svg" alt="">
                </div>
            </div>
            <div class="col-md-4 p-0">
                <div class="alll-offer-list bg-gray">
                    <div class="icon-offer"><img src="assets/user/img/off3.svg" alt="icon"></div>
                    <div class="offer-details">
                        <p><strong>Join our team:</strong> Be part of something big-shape the future of fashion with
                            Rytoyu! </p>
                        <button class="btn orange-bg"><span>Apply</span></button>
                    </div>
                    <img class="shape" src="assets/user/img/shape.svg" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- end become a partner -->
    <div class="clearfix"></div>
@endsection

@push('js') @endpush
