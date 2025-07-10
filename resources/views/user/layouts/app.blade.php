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
          href="{{ asset(siteSettings()['favicon'] ?? ecommerceIcon()) }}">
    <link rel="shortcut icon" href="{{ asset(siteSettings()['favicon'] ?? ecommerceIcon()) }}">
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
    <link href="{{ asset('assets/user/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/user/css/theme-green-1.css') }}" rel="stylesheet" id="theme-config-link">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
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
                    <div class="cart-items-inner" id="mini-cart-item">


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
                        <li class="hidden-xs"><a href="{{ route('about') }}">About</a></li>
                        <li class="hidden-xs"><a href="{{ route('contact') }}">Contact</a></li>
                        <li class="hidden-xs"><a href="{{ route('faq') }}">FAQ</a></li>
                    </ul>
                </div>
                <!--  <div class="top-bar-left">
                   <label class="free-o"><span>Free Shipping With Orders</span> <strong>Over  Tk.2000</strong></label>
                   </div> -->
                <div class="top-bar-right">
                    <ul class="list-inline">
                        @auth
                            <li class="icon-user">
                                <a href="{{ route('user-profile') }}">
                                    <img src="{{ asset('assets/user/img/user.svg') }}" alt=""/>
                                    <span>My Account</span>
                                </a>
                            </li>
                            <li class="icon-user">
                                <a href="{{ route('user-logout') }}">
                                    <img src="{{ asset('assets/user/img/logout.svg') }}" alt=""/>
                                    <span>Logout</span>
                                </a>
                            </li>
                        @else
                            <li class="icon-user">
                                <a href="{{ route('login') }}">
                                    <img src="{{ asset('assets/user/img/user.svg') }}" alt=""/>
                                    <span>Login</span>
                                </a>
                            </li>
                            <li class="icon-form">
                                <a href="{{ route('register') }}">
                                    <img src="{{ asset('assets/user/img/mem.svg') }}" alt=""/>
                                    <span>Not a Member? <span class="colored">Sign Up</span></span>
                                </a>
                            </li>
                        @endauth
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
                            @foreach(megaMenus() as $menu)
                                <li class="megamenu">
                                    <a href="{{ route('product-lists',['category' => $menu->slug]) }}">{{ $menu->name ?? '' }}</a>
                                    @if(count($menu->subcategories))
                                        <ul>
                                            <li class="row">
                                                @foreach($menu->subcategories as $subcategory)
                                                    <div class="col-md-4">
                                                        <h4 class="block-title">
                                                            <span>
                                                                <a href="{{ route('product-lists',['category' => $menu->slug, 'subcategory' => $subcategory->slug]) }}">{{ $subcategory->name ?? '' }}</span></a>

                                                        </h4>
                                                        @if(count($subcategory->sub_subcategories))
                                                            <ul>
                                                                @foreach($subcategory->sub_subcategories as $sub_subcategory)
                                                                    <li>
                                                                        <a href="{{ route('product-lists',['category' => $menu->slug, 'subcategory' => $subcategory->slug,'sub_subcategory' => $sub_subcategory->slug]) }}">{{ $sub_subcategory->name ?? '' }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </li>
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                            <li class="megamenu">
                                <a href="#">BRANDS</a>
                                <ul>
                                    <li class="row">
                                        <div class="col-md-4">
                                            <h4 class="block-title"><span>Explore</span></h4>
                                            <ul>
                                                @foreach(getBrands() as $brand)
                                                    <li>
                                                        <a href="{{ route('product-lists',['brand' => $brand->slug]) }}">{{ $brand->slug }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="{{ route('product-lists') }}" class="orange-text">SALE</a></li>
                        </ul>
                    </nav>
                    <!-- /Navigation -->
                </div>
                <!-- Logo -->
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset(siteSettings()['logo'] ?? devLogo()) }}"
                             alt="logo"/></a>
                </div>
                <!-- /Logo -->
                <!-- Header search -->
                <div class="header-search">
                    <input name="search" class="form-control searchInput" type="text"
                           placeholder="Search for products, brands and more"
                           value="{{ implode(' ', session('search_keywords_' . session('user_search_key'), [])) }}"/>
                    <button class="searchBtn"><i class="fa fa-search"></i></button>
                </div>
                <!-- /Header search -->
                <!-- Header shopping cart -->
                <div class="header-cart">
                    <div class="cart-wrapper">
                        @if(\Illuminate\Support\Facades\Auth::check())
                        <a href="wishlist.html" class="btn btn-theme-transparent hidden-xs hidden-sm"><i
                                class="fa-regular fa-heart"></i></a>
                        @endif
                        <a href="#" class="btn btn-theme-transparent cart-value" data-toggle="modal"
                           data-target="#popup-cart"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs"
                                                                                               id="cart-item-total">  </span>
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
        @yield('content')
    </div>
    <!-- /CONTENT AREA -->
    <div class="chat-wa">
        <img src="{{ asset('assets/user/img/chat.svg') }}">
    </div>
    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-widgets">
            <div class="container">
                <div class="col-md-12 text-center border-b">
                    <div class="form-list-search">
                        <input type="text" name="search" placeholder="Search for products brands and more"
                               class="form-control searchInput"
                               value="{{ implode(' ', session('search_keywords_' . session('user_search_key'), [])) }}">
                        <button class="btn orange-bg searchBtn">SERACH<i class="fa-solid fa-magnifying-glass"></i>
                        </button>


                    </div>
                </div>
                <div class="col-md-12">
                    <ul class="list-inline list-group footer-nav">
                        @foreach(activeCategories() as $category)
                        <li>
                            <a href="{{ route('product-lists', ['category' => $category->slug]) }}">{{ $category->name ?? '' }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="widget">
                            <h4 class="widget-title">FOLLOW US</h4>
                            <ul class="social-icons">
                                <li><a href="{{ siteSettings()['facebook_url'] ?? '#' }}" class="facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="{{ siteSettings()['twitter_url'] ?? '#' }}" class="twitter"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="{{ siteSettings()['instagram_url'] ?? '#' }}" class="instagram"><i class="fa-brands fa-tiktok"></i></a></li>
                                <li><a href="#" class="pinterest"><i class="fa-brands fa-linkedin-in"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <a href="{{ route('home') }}"><img class="logo-f" src="{{ asset(siteSettings()['logo']) }}"
                                                           alt="logo"></a>
                        <p class="p-f">
                            Corporate Office<br>
                            {{ siteSettings()['address'] ?? '' }}
                        </p>
                        <h4 class="h4-f">Need help? Call Us:<span
                                class="orange-text">{{ siteSettings()['company_mobile'] ?? '' }}</span></h4>
                        <p class="mail-f">{{ siteSettings()['company_email'] ?? '' }}</p>
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
                        <div class="copyright">
                            © Copyright {{ date('Y') }} {{ siteSettings()['company_name'] }}. All Rights Reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- /FOOTER -->
    <div id="to-top" class="to-top"><i class="fa fa-angle-up"></i></div>
</div>
<!-- /WRAPPER -->
<!-- product -details modal -->
<div class="modal" id="productView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg custom-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-thumbnails" id="productInfo">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!--<![endif]-->
<script src="{{ asset('assets/admin/js/axios.js') }}"></script>
<script src="{{ asset('assets/admin/js/helpers.js') }}"></script>
<script src="{{ asset('assets/user/js/common.js') }}"></script>
{{--<script src="{{ asset('assets/user/js/product-details.js') }}"></script>--}}
<script src="{{ asset('assets/user/js/checkout_manage.js') }}"></script>
@stack('js')
</body>
</html>
