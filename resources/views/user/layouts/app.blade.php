<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" base_url="{!! url('/') !!}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title',siteSettings()['company_name'])</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{ asset('assets/user/images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/user/images/favicon.png') }}">
    <!-- CSS Global -->
    <link href="{{ asset('assets/user/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/user/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/user/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/user/plugins/prettyphoto/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/user/plugins/owl-carousel2/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/user/plugins/owl-carousel2/assets/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/user/plugins/animate/animate.min.css') }}" rel="stylesheet">
    <!-- Theme CSS -->
    <link href="{{ asset('assets/user/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/user/css/theme-green-1.css') }}" rel="stylesheet" id="theme-config-link">
    <!-- Head Libs -->
    <script src="{{ asset('assets/user/plugins/modernizr.custom.js') }}"></script>
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/user/plugins/iesupport/html5shiv.js') }}"></script>
    <script src="{{ asset('assets/user/plugins/iesupport/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body id="home" class="wide">
<!-- PRELOADER -->
<div id="preloader">
    <div id="preloader-status">
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
        <div id="preloader-title">Loading</div>
    </div>
</div>
<!-- /PRELOADER -->
<!-- WRAPPER -->
<div class="wrapper">
    <!-- Popup: Shopping cart items -->
    <div class="modal fade popup-cart" id="popup-cart" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="container">
                <div class="cart-items">
                    <div class="cart-items-inner">
                        <div class="media">
                            <a class="pull-left" href="#"><img class="media-object item-image"
                                                               src="{{ asset('assets/user/img/preview/shop/order-1s.jpg') }}"
                                                               alt=""></a>
                            <p class="pull-right item-price">TK:1,400.00</p>
                            <div class="media-body">
                                <h4 class="media-heading item-title"><a href="#">1x Standard Product</a></h4>
                                <p class="item-desc">Lorem ipsum dolor</p>
                            </div>
                        </div>
                        <div class="media">
                            <p class="pull-right item-price">TK:1,400.00</p>
                            <div class="media-body">
                                <h4 class="media-heading item-title summary">Subtotal</h4>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-body">
                                <div>
                                    <a href="#" class="btn btn-theme bg-red" data-dismiss="modal">Close</a><!--
                                    --><a href=""
                                          class="btn btn-theme btn-theme-transparent btn-call-checkout chek-orange">Checkout</a>
                                </div>
                                <!-- hopping-cart.html -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Popup: Shopping cart items -->
    <!-- Header top bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-inner">
                <div class="top-bar-left">
                    <ul class="list-inline">
                        <li class="hidden-xs"><a href="">About</a></li>
                        <li class="hidden-xs"><a href="">My Account</a></li>
                        <li class="hidden-xs"><a href="">Contact</a></li>
                        <li class="hidden-xs"><a href="">FAQ</a></li>
                    </ul>
                </div>
                <!--  <div class="top-bar-left">
                   <label class="free-o"><span>Free Shipping With Orders</span> <strong>Over  Tk.2000</strong></label>
                   </div> -->
                <div class="top-bar-right">
                    <ul class="list-inline">
                        <li class="icon-user"><a href="accountinformation.html"><img src="assets/user/img/user.svg"
                                                                                     alt=""/>
                                <span>My Account</span></a></li>
                        <li class="icon-user"><a href="login.html"><img src="assets/user/img/user.svg" alt=""/> <span>Login</span></a>
                        </li>
                        <li class="icon-form"><a href="registration.html"><img src="assets/user/img/mem.svg" alt=""/>
                                <span>Not a Member? <span class="colored">Sign Up</span></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Header top bar -->
    <!-- HEADER -->
    <header class="header fixed">
        <div class="header-wrapper">
            <div class="container">
                <div class="navigation-wrapper">
                    <!-- Navigation -->
                    <nav class="navigation closed clearfix">
                        <a href="#" class="menu-toggle-close btn"><i class="fa fa-times"></i></a>
                        <ul class="nav sf-menu">
                            <li class="megamenu">
                                <a href="#">WOMEN</a>
                                <ul>
                                    <li class="row">
                                        <div class="col-md-4">
                                            <h4 class="block-title"><span>Winter</span></h4>
                                            <ul>
                                                <li><a href="#">Dresses</a></li>
                                                <li><a href="#">Rompers & Jumpsuits</a></li>
                                                <li><a href="#">Bodysuits</a></li>
                                                <li><a href="#">Shirts & Blouses</a></li>
                                                <li><a href="#">Coats & Jackets</a></li>
                                                <li><a href="#">Blazers</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="block-title"><span>Casual Dresses</span></h4>
                                            <ul>
                                                <li><a href="#">T-Shirts & Vests</a></li>
                                                <li><a href="#">Sweaters & Cardigans</a></li>
                                                <li><a href="#">Hoodies & Sweats</a></li>
                                                <li><a href="#">Coats & Jackets</a></li>
                                                <li><a href="#">Shirts</a></li>
                                                <li><a href="#">Shorts</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="block-title"><span>Our Featured Offers</span></h4>
                                            <ul>
                                                <li><a href="#">T-Shirts & Vests</a></li>
                                                <li><a href="#">Sweaters & Cardigans</a></li>
                                                <li><a href="#">Hoodies & Sweats</a></li>
                                                <li><a href="#">Coats & Jackets</a></li>
                                                <li><a href="#">Shirts</a></li>
                                                <li><a href="#">Shorts</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="megamenu">
                                <a href="#">MEN</a>
                                <ul>
                                    <li class="row">
                                        <div class="col-md-4">
                                            <h4 class="block-title"><span>Winter</span></h4>
                                            <ul>
                                                <li><a href="#">Dresses</a></li>
                                                <li><a href="#">Rompers & Jumpsuits</a></li>
                                                <li><a href="#">Bodysuits</a></li>
                                                <li><a href="#">Shirts & Blouses</a></li>
                                                <li><a href="#">Coats & Jackets</a></li>
                                                <li><a href="#">Blazers</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="block-title"><span>Casual Dresses</span></h4>
                                            <ul>
                                                <li><a href="#">T-Shirts & Vests</a></li>
                                                <li><a href="#">Sweaters & Cardigans</a></li>
                                                <li><a href="#">Hoodies & Sweats</a></li>
                                                <li><a href="#">Coats & Jackets</a></li>
                                                <li><a href="#">Shirts</a></li>
                                                <li><a href="#">Shorts</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="block-title"><span>Our Featured Offers</span></h4>
                                            <ul>
                                                <li><a href="#">T-Shirts & Vests</a></li>
                                                <li><a href="#">Sweaters & Cardigans</a></li>
                                                <li><a href="#">Hoodies & Sweats</a></li>
                                                <li><a href="#">Coats & Jackets</a></li>
                                                <li><a href="#">Shirts</a></li>
                                                <li><a href="#">Shorts</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="megamenu">
                                <a href="#">BRANDS</a>
                                <ul>
                                    <li class="row">
                                        <div class="col-md-4">
                                            <h4 class="block-title"><span>Sonos</span></h4>
                                            <ul>
                                                <li><a href="#">Sonos 1</a></li>
                                                <li><a href="#">Sonos 2</a></li>
                                                <li><a href="#">Sonos 3</a></li>
                                                <li><a href="#">Sonos 4</a></li>
                                                <li><a href="#">Sonos 5</a></li>
                                                <li><a href="#">Sonos 6</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="block-title"><span>Toshiba</span></h4>
                                            <ul>
                                                <li><a href="#">Toshiba 1</a></li>
                                                <li><a href="#">Toshiba 2</a></li>
                                                <li><a href="#">Toshiba 3</a></li>
                                                <li><a href="#">Toshiba 4</a></li>
                                                <li><a href="#">Toshiba 5</a></li>
                                                <li><a href="#">Toshiba 6</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="block-title"><span>Xiaomi</span></h4>
                                            <ul>
                                                <li><a href="#">Xiaomi 1</a></li>
                                                <li><a href="#">Xiaomi 2</a></li>
                                                <li><a href="#">Xiaomi 3</a></li>
                                                <li><a href="#">Xiaomi 4</a></li>
                                                <li><a href="#">Xiaomi 5</a></li>
                                                <li><a href="#">Xiaomi 6</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="" class="orange-text">SALE</a></li>
                        </ul>
                    </nav>
                    <!-- /Navigation -->
                </div>
                <!-- Logo -->
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="{{ asset(siteSettings()['logo'] ?? devLogo()) }}" alt="logo"/></a>
                </div>
                <!-- /Logo -->
                <!-- Header search -->
                <div class="header-search">
                    <input class="form-control" type="text" placeholder="Search for products brands and more"/>
                    <button><i class="fa fa-search"></i></button>
                </div>
                <!-- /Header search -->
                <!-- Header shopping cart -->
                <div class="header-cart">
                    <div class="cart-wrapper">
                        <a href="wishlist.html" class="btn btn-theme-transparent hidden-xs hidden-sm"><i
                                class="fa-regular fa-heart"></i></a>
                        <a href="#" class="btn btn-theme-transparent cart-value" data-toggle="modal"
                           data-target="#popup-cart"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs"> TK:1,400.00 </span>
                            <i class="fa fa-angle-down cart-drop"></i></a>
                        <!-- Mobile menu toggle button -->
                        <a href="#" class="menu-toggle btn btn-theme-transparent"><i class="fa fa-bars"></i></a>
                        <!-- /Mobile menu toggle button -->
                    </div>
                </div>
                <!-- Header shopping cart -->
                <div class="text-slider">
                    <span>MAKING </span>
                    <div id="carousel-example-generic " class="carousel carousel-fade slide slider-slo"
                         data-ride="carousel">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <div class="carousel-caption">
                                    BANGLADESH
                                </div>
                            </div>
                            <div class="item">
                                <div class="carousel-caption">
                                    YOU
                                </div>
                            </div>
                        </div>
                    </div>
                    <span>LOOK <i>GOOD</i><strong class="orange-text font-s">.</strong></span>
                </div>
            </div>
        </div>
    </header>
    <!-- /HEADER -->
    <!-- CONTENT AREA -->
    <div class="content-area">
        <!-- PAGE -->
        <section class="page-section no-padding slider slider-banner">
            <div class="container full-width">
                <div class="main-slider">
                    <div class="owl-carousel" id="main-slider">
                        <!-- Slide 1 -->
                        <div class="item slide1">
                            <img class="slide-img" src="{{ asset('assets/user/img/1.png') }}" alt=""/>
                            <div class="caption">
                                <div class="container">
                                    <div class="div-table">
                                        <div class="div-cell">
                                            <div class="caption-content">
                                                <h2 class="caption-title">Lifestyle Collection</h2>
                                                <h3 class="caption-subtitle">FOR TRAVELING </h3>
                                                <h5 class="sale-p">Sale Up to
                                                    <label class="orange-text">
                                                        30% Off
                                                        <span>
                                                            <img src="{{ asset('assets/user/img/border.png') }}" alt="img">
                                                         </span>
                                                    </label>
                                                </h5>
                                                <p class="caption-text">
                                                    <a class="btn btn-theme" href="#">SHOP NOW</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Slide 1 -->
                        <!-- Slide 2 -->
                        <div class="item slide2">
                            <img class="slide-img" src="{{ asset('assets/user/img/1.png') }}" alt=""/>
                            <div class="caption">
                                <div class="container">
                                    <div class="div-table">
                                        <div class="div-cell">
                                            <div class="caption-content">
                                                <h2 class="caption-title">Lifestyle Collection</h2>
                                                <h3 class="caption-subtitle"><span>FOR TRAVELING </span></h3>
                                                <h5 class="sale-p">Sale Up to
                                                    <label class="orange-text">
                                                        30% Off
                                                        <span>
                                                            <img src="{{ asset('assets/user/img/border.png') }}" alt="img">
                                                         </span>
                                                    </label>
                                                </h5>
                                                <p class="caption-text">
                                                    <a class="btn btn-theme" href="#">SHOP NOW</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Slide 2 -->
                    </div>
                </div>
            </div>
            <div class="notification-offer">
                <!--       <div class="container-fluid">
                   <div class="marquee">
                   <div class="track">
                   <div class="content">
                   <ul class="ul-m">
                   <li>
                   <span>Free Shipping With Orders <strong>Over Tk.2000</strong></span>
                   <span>Sign-Up To Receive Flat <strong>Tk.100 off</strong></span>
                   </li>


                   </div>
                   </div>
                   </div> -->
                <marquee behavior="scroll" direction="right" scrollamount="3">
                    <ul class="ul-m">
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                        <li>Free Shipping With Orders <strong>Over Tk.2000</strong></li>
                        <li>Sign-Up To Receive Flat <strong>Tk.100 off</strong></li>
                    </ul>
                </marquee>
            </div>
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
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="{{ asset('assets/user/img/s1.png') }}" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/s2.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                            <p class="p-title">Brand Name</p>
                            <div class="price">
                                <ins>TK:1,400.00</ins>
                                <del>TK:1800.00</del>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail no-border no-padding">
                        <div class="media">
                            <img class="img-sl" src="assets/user/img/s4.png" alt=""/>
                            <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
                                    class="fa-regular fa-eye"></i></button>
                        </div>
                        <div class="caption text-center">
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
                            <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
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
</div>
<!-- /CONTENT AREA -->
<div class="chat-wa">
    <img src="assets/user/img/chat.svg">
</div>
<!-- FOOTER -->
<footer class="footer">
    <div class="footer-widgets">
        <div class="container">
            <div class="col-md-12 text-center border-b">
                <div class="form-list-search">
                    <input type="text" name="" placeholder="Search for products brands and more" class="form-control">
                    <button class="btn orange-bg">SERACH<i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
            <div class="col-md-12">
                <ul class="list-inline list-group footer-nav">
                    <li>
                        <a href="">WOMEN</a>
                    </li>
                    <li>
                        <a href="">MEN</a>
                    </li>
                    <li>
                        <a href="">BRANDS</a>
                    </li>
                    <li>
                        <a href="">SHOP</a>
                    </li>
                    <li>
                        <a href="">NEW</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="widget">
                        <h4 class="widget-title">FOLLOW US</h4>
                        <ul class="social-icons">
                            <li><a href="#" class="facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="#" class="twitter"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="#" class="instagram"><i class="fa-brands fa-tiktok"></i></a></li>
                            <li><a href="#" class="pinterest"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <a href="index"><img class="logo-f" src="assets/user/img/logo.svg" alt="logo"></a>
                    <p class="p-f">
                        Corporate Office: Rupayan Shopping Square, Level-5, Plot-2, Block-G,<br>
                        Sayem Sobhan Anvir Road, Bashundhara R/A, Dhaka-1229, Bangladesh.
                    </p>
                    <h4 class="h4-f">Need help? Call Us:<span class="orange-text">01712768782</span></h4>
                    <p class="mail-f">contact@rytoyu.com</p>
                </div>
                <div class="col-md-3">
                    <ul class="ul-link-f">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-meta">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="copyright">© Copyright 2024 rytoyu. All Rights Reserved.</div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- /FOOTER -->
<div id="to-top" class="to-top"><i class="fa fa-angle-up"></i></div>
</div>
<!-- /WRAPPER -->
<!-- product -datails modal -->
<div class="modal" id="addcart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg custom-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-thumbnails">
                <div class="row product-single">
                    <div class="col-md-6">
                        <div class="owl-carousel img-carousel img-carousel2">
                            <div class="item">
                                <a class="btn btn-theme btn-theme-transparent btn-zoom" href="assets/user/img/s1.png"
                                   data-gal="prettyPhoto"><i class="fa fa-plus"></i></a>
                                <a href="assets/user/img/s1.png" data-gal="prettyPhoto"><img class="img-responsive"
                                                                                             src="assets/user/img/s1.png"
                                                                                             alt=""/></a>
                            </div>
                            <div class="item">
                                <a class="btn btn-theme btn-theme-transparent btn-zoom"
                                   href="assets/user/img/preview/shop/product-1-big.jpg" data-gal="prettyPhoto"><i
                                        class="fa fa-plus"></i></a>
                                <a href="assets/user/img/preview/shop/product-1-big.jpg" data-gal="prettyPhoto"><img
                                        class="img-responsive" src="assets/user/img/preview/shop/product-1-big.jpg"
                                        alt=""/></a>
                            </div>
                            <div class="item">
                                <a class="btn btn-theme btn-theme-transparent btn-zoom"
                                   href="assets/user/img/preview/shop/product-1-big.jpg" data-gal="prettyPhoto"><i
                                        class="fa fa-plus"></i></a>
                                <a href="assets/user/img/preview/shop/product-1-big.jpg" data-gal="prettyPhoto"><img
                                        class="img-responsive" src="assets/user/img/preview/shop/product-1-big.jpg"
                                        alt=""/></a>
                            </div>
                            <div class="item">
                                <a class="btn btn-theme btn-theme-transparent btn-zoom"
                                   href="assets/user/img/preview/shop/product-1-big.jpg" data-gal="prettyPhoto"><i
                                        class="fa fa-plus"></i></a>
                                <a href="assets/user/img/preview/shop/product-1-big.jpg" data-gal="prettyPhoto"><img
                                        class="img-responsive" src="assets/user/img/preview/shop/product-1-big.jpg"
                                        alt=""/></a>
                            </div>
                        </div>
                        <div class="row product-thumbnails">
                            <div class="col-xs-2 col-sm-2 col-md-3"><a href="#"
                                                                       onclick="jQuery('.img-carousel').trigger('to.owl.carousel', [0, 300]);"><img
                                        src="assets/user/img/s1.png" alt=""/></a></div>
                            <div class="col-xs-2 col-sm-2 col-md-3"><a href="#"
                                                                       onclick="jQuery('.img-carousel').trigger('to.owl.carousel', [1, 300]);"><img
                                        src="assets/user/img/preview/shop/product-thumb-2.jpg" alt=""/></a></div>
                            <div class="col-xs-2 col-sm-2 col-md-3"><a href="#"
                                                                       onclick="jQuery('.img-carousel').trigger('to.owl.carousel', [2, 300]);"><img
                                        src="assets/user/img/preview/shop/product-thumb-3.jpg" alt=""/></a></div>
                            <div class="col-xs-2 col-sm-2 col-md-3"><a href="#"
                                                                       onclick="jQuery('.img-carousel').trigger('to.owl.carousel', [3, 300]);"><img
                                        src="assets/user/img/preview/shop/product-thumb-4.jpg" alt=""/></a></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="back-to-category">
                            <span class="link"><i class="fa fa-angle-left"></i> Back to <a
                                    href="category.html">Category</a></span>
                        </div>
                        <div class="brand-name">
                            <a href=""> RichMan</a>
                        </div>
                        <h2 class="product-title">Standard Product Header Here</h2>
                        <div class="product-rating clearfix">
                            <div class="rating">
                                <span class="star"></span><!--
                                 --><span class="star active"></span><!--
                                 --><span class="star active"></span><!--
                                 --><span class="star active"></span><!--
                                 --><span class="star active"></span>
                            </div>
                            <a class="reviews" href="#">16 reviews</a>
                        </div>
                        <div class="product-availability">Availability: <strong>In stock</strong> 21 Item(s)</div>
                        <div class="product-price">TK:10,000</div>
                        <hr class="page-divider"/>
                        <div class="product-text ">
                            <p>Etiam eu justo ut nisi sollicitudin bibendum. Fusce sed dui ac turpis vulputate tincidunt
                                vel sed magna. Pellentesque <strong>pretium</strong> mollis metus vel feugiat. Cum
                                sociis natoque penatibus <strong>et magnis</strong> dis parturient montes, nascetur
                                ridiculus mus. <strong>Vestibulum</strong> commodo mauris eget sapien posuere, id <a
                                    href="#">efficitur mi tristique</a>.</p>
                            <ul>
                                <li>- Cras tristique neque a mauris volutpat, eget sodales neque elementum.</li>
                                <li>- Vestibulum iaculis velit sed dolor suscipit pretium.</li>
                            </ul>
                        </div>
                        <hr class="page-divider"/>
                        <h4 class="color-list">Color: <span>Gray</span></h4>
                        <div class="widget widget-colors">
                            <ul>
                                <li>
                                    <div class="size-list-color">
                                        <input id="radio-col1a" class="radio-custom" name="sizesb" type="radio">
                                        <label for="radio-col1a" class="radio-custom-label">
                                            <span style="background-color: #161618"></span>
                                        </label>
                                    </div>

                                </li>
                                <li>
                                    <div class="size-list-color">
                                        <input id="radio-col2b" class="radio-custom" name="sizesb" type="radio">
                                        <label for="radio-col2b" class="radio-custom-label">
                                            <span style="background-color: #e74c3c"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>

                                    <div class="size-list-color">
                                        <input id="radio-col3c" class="radio-custom" name="sizesb" type="radio">
                                        <label for="radio-col3c" class="radio-custom-label">
                                            <span style="background-color: #783ce7"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>

                                    <div class="size-list-color">
                                        <input id="radio-col4d" class="radio-custom" name="sizesb" type="radio">
                                        <label for="radio-col4d" class="radio-custom-label">
                                            <span style="background-color: #3498db"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>

                                    <div class="size-list-color">
                                        <input id="radio-col5e" class="radio-custom" name="sizesb" type="radio">
                                        <label for="radio-col5e" class="radio-custom-label">
                                            <span style="background-color: #00a847"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>

                                    <div class="size-list-color">
                                        <input id="radio-col6f" class="radio-custom" name="sizesb" type="radio">
                                        <label for="radio-col6f" class="radio-custom-label">
                                            <span style="background-color: #3ce7d9"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>

                                    <div class="size-list-color">
                                        <input id="radio-col7g" class="radio-custom" name="sizesb" type="radio">
                                        <label for="radio-col7g" class="radio-custom-label">
                                            <span style="background-color: #fa17bc"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>

                                    <div class="size-list-color">
                                        <input id="radio-col8h" class="radio-custom" name="sizesb" type="radio">
                                        <label for="radio-col8h" class="radio-custom-label">
                                            <span style="background-color: #a87e00"></span>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h4 class="color-list margin-size">Size<sup>*</sup></h4>
                        <ul class="size-shop">
                            <li>

                                <div class="size-list">
                                    <input id="radio-xsxa" class="radio-custom" name="sizesc" type="radio">
                                    <label for="radio-xsxa" class="radio-custom-label">
                                        <span>XS</span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="size-list">
                                    <input id="radio-ssa" class="radio-custom" name="sizesc" type="radio">
                                    <label for="radio-ssa" class="radio-custom-label">
                                        <span>S</span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="size-list">
                                    <input id="radio-mma" class="radio-custom" name="sizesc" type="radio">
                                    <label for="radio-mma" class="radio-custom-label">
                                        <span>M</span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="size-list">
                                    <input id="radio-lla" class="radio-custom" name="sizesc" type="radio">
                                    <label for="radio-lla" class="radio-custom-label">
                                        <span>L</span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="size-list">
                                    <input id="radio-xlxla" class="radio-custom" name="sizesc" type="radio">
                                    <label for="radio-xlxla" class="radio-custom-label">
                                        <span>XL</span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="size-list">
                                    <input id="radio-xxlxxla" class="radio-custom" name="sizesc" type="radio">
                                    <label for="radio-xxlxxla" class="radio-custom-label">
                                        <span>XXL</span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                        <hr class="page-divider"/>
                        <div class="buttons">
                            <div class="quantity">
                                <button class="btn"><i class="fa fa-minus"></i></button>
                                <input class="form-control qty" type="number" step="1" min="1" name="quantity" value="1"
                                       title="Qty">
                                <button class="btn"><i class="fa fa-plus"></i></button>
                            </div>
                            <button class="btn btn-theme btn-cart btn-icon-left add-to-cart" type="submit"><i
                                    class="fa fa-shopping-cart"></i>Add to cart
                            </button>
                            <button class="btn btn-theme btn-wish-list btn-cart-m"><i
                                    class="fa-regular fa-heart orange-text"></i></button>
                            <button class="btn btn-theme btn-compare btn-cart-m"><i class="fa fa-exchange"></i></button>
                        </div>

                        <hr class="page-divider small"/>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end product details modal-->
<!-- JS Global -->
<script src="{{ asset('assets/user/plugins/jquery/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('assets/user/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/user/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/user/plugins/superfish/js/superfish.min.js') }}"></script>
<script src="{{ asset('assets/user/plugins/prettyphoto/js/jquery.prettyPhoto.js') }}"></script>
<script src="{{ asset('assets/user/plugins/owl-carousel2/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/user/plugins/jquery.sticky.min.js') }}"></script>
<script src="{{ asset('assets/user/plugins/jquery.easing.min.js') }}"></script>
<script src="{{ asset('assets/user/plugins/jquery.smoothscroll.min.js') }}"></script>
<script src="{{ asset('assets/user/plugins/smooth-scrollbar.min.js') }}"></script>
<!-- JS Page Level -->
<script src="{{ asset('assets/user/js/theme.js') }}"></script>
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="{{ asset('assets/user/plugins/jquery.cookie.js') }}"></script>
<!--<![endif]-->
</body>
</html>
