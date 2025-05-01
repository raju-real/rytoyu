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
                              <input class="form-control" type="text" placeholder="Search">
                              <button><i class="fa fa-search"></i></button>
                           </div>
                        </div>
                        <!-- /widget search -->
                        <!-- widget shop categories -->
                        <div class="widget shop-categories mt-10">
                           <h4 class="widget-title">Categories</h4>
                           <div class="widget-content">
                              <ul>
                                 <li>
                                    <a href="#" class="orange-text"><strong>MEN</strong></a>
                                    <ul class="children">
                                       <li>
                                          <a href="#">Sweaters & Knits
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Denim
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Pants
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Shorts
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                    </ul>
                                 </li>
                                 <li>
                                    <a href="#" class="orange-text"><strong>WOMEN</strong></a>
                                    <ul class="children">
                                       <li>
                                          <a href="#">Sweaters & Knits
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Jackets & Coats
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Denim
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Pants
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Shorts
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                    </ul>
                                 </li>
                                 <li>
                                    <a href="#" class="orange-text"><strong>KIDS</strong></a>
                                    <ul class="children">
                                       <li>
                                          <a href="#">Sweaters & Knits
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Jackets & Coats
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Denim
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Pants
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Shorts
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                    </ul>
                                 </li>
                                 <li>
                                    <a href="#" class="orange-text"><strong>TOP SELLERS</strong></a>
                                    <ul class="children">
                                       <li>
                                          <a href="#">Sweaters & Knits
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Jackets & Coats
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Denim
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Pants
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">Shorts
                                          <span class="count">12</span>
                                          </a>
                                       </li>
                                    </ul>
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <!-- /widget shop categories -->
                        <!-- widget  product filter -->
                        <div class="widget shop-categories mt-10 p-filter pb-10">
                           <h4>Filter by price</h4>
                           <p class="range-filter">
                              <label for="amount">Price:</label>
                              TK:
                              <input class="amount" id="amount_min" type="text">
                              <span> -</span> TK:
                              <input class="amount" id="amount_max" type="text">
                           </p>
                           <div id="slider-range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                              <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                           </div>
                        </div>
                        <!-- /widget product price -->
                        <!-- widget  BRAND -->
                        <div class="widget shop-categories mt-10 p-filter">
                           <h4>BRAND</h4>
                           <div class="bran-radio">
                              <div class="radio">
                                 <div>
                                    <input id="radio-1" class="radio-custom" name="radio-group" type="checkbox" checked>
                                    <label for="radio-1" class="radio-custom-label">Xiaomi</label>
                                 </div>
                                 <div>
                                    <input id="radio-2" class="radio-custom"name="radio-group" type="checkbox">
                                    <label for="radio-2" class="radio-custom-label">Toshiba</label>
                                 </div>
                                 <div>
                                    <input id="radio-3" class="radio-custom" name="radio-group" type="checkbox">
                                    <label for="radio-3" class="radio-custom-label">Sonos</label>
                                 </div>
                                 <div>
                                    <input id="radio-4" class="radio-custom" name="radio-group" type="checkbox">
                                    <label for="radio-4" class="radio-custom-label">TP-LINK Technologies</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- /widget BRAND -->
                        <!-- widget  BRAND -->
                        <div class="widget shop-categories mt-10 p-filter">
                           <h4>STOCK STATUS</h4>
                           <div class="bran-radio">
                              <div class="radio">
                                 <div>
                                    <input id="radio-a" class="radio-custom" name="radio-group" type="radio" >
                                    <label for="radio-a" class="radio-custom-label">YES</label>
                                 </div>
                                 <div>
                                    <input id="radio-b" class="radio-custom"name="radio-group" type="radio">
                                    <label for="radio-b" class="radio-custom-label">NO</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- /widget BRAND -->
                     </aside>
                     <!-- /SIDEBAR -->
                     <!-- CONTENT -->
                     <div class="col-md-9 content">
                        <div class="main-slider sub">
                           <div class="owl-carousel" id="main-slider">
                              <!-- Slide 1 -->
                              <div class="item slide1 sub">
                                 <img class="slide-img slide-i-2" src="assets/img/ca.png" alt=""/>
                              </div>
                              <!-- /Slide 1 -->
                              <!-- Slide 2 -->
                              <div class="item slide2 sub">
                                 <img class="slide-img slide-i-2" src="assets/img/preview/slider/slide-1-sub.jpg" alt=""/>
                              </div>
                              <!-- /Slide 2 -->
                           </div>
                        </div>
                        <!-- shop-sorting -->
                        <div class="shop-sorting">
                           <div class="row">
                              <div class="col-sm-3 text-left-sm">
                                 <a class="btn btn-theme btn-theme-transparent btn-theme-sm grid-style" href="#"><i class="fa-solid fa-bars"></i></a>
{{--                                 <a class="btn btn-theme btn-theme-transparent btn-theme-sm grid-style2" href="#"><i class="fa-solid fa-list"></i></a>--}}
                              </div>
                              <div class="col-sm-9">
                                 <div class="radio price-p">
                                 <div class="price-block">
                                    <input id="radio-c" class="radio-custom" name="radio-group" checked type="checkbox" >
                                    <label for="radio-c" class="radio-custom-label">Less than: 500</label>
                                 </div>
                                   <div class="price-block">
                                    <input id="radio-d" class="radio-custom"name="radio-group" type="checkbox">
                                    <label for="radio-d" class="radio-custom-label">Less than: 1,500</label>
                                 </div>
                                  <div class="price-block">
                                    <input id="radio-e" class="radio-custom"name="radio-group" type="checkbox">
                                    <label for="radio-e" class="radio-custom-label">Women</label>
                                 </div>
                                  <div class="price-block">
                                    <input id="radio-f" class="radio-custom"name="radio-group" type="checkbox">
                                    <label for="radio-f" class="radio-custom-label">Men</label>
                                 </div>
                              </div>
                              </div>
                           </div>
                        </div>
                        <!-- /shop-sorting -->
                        <!-- Products grid -->
                        <div class="row products grid">
                           <div class="col-md-4 cate-p">
                              <div class="thumbnail no-border no-padding">
                                 <div class="media">
                                    <img class="img-sl" src="assets/img/s1.png" alt=""/>
                                    <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i class="fa-regular fa-eye"></i></button>
                                 </div>
                                 <div class="caption text-center">
                                    <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                                    <p class="p-title">Brand Name</p>
                                    <div class="price"><ins>TK:1,400.00</ins><del>TK:1800.00</del></div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 cate-p">
                              <div class="thumbnail no-border no-padding">
                                 <div class="media">
                                    <img class="img-sl" src="assets/img/s1.png" alt=""/>
                                    <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i class="fa-regular fa-eye"></i></button>
                                 </div>
                                 <div class="caption text-center">
                                    <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                                    <p class="p-title">Brand Name</p>
                                    <div class="price"><ins>TK:1,400.00</ins><del>TK:1800.00</del></div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 cate-p">
                              <div class="thumbnail no-border no-padding">
                                 <div class="media">
                                    <img class="img-sl" src="assets/img/s2.png" alt=""/>
                                    <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i class="fa-regular fa-eye"></i></button>
                                 </div>
                                 <div class="caption text-center">
                                    <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                                    <p class="p-title">Brand Name</p>
                                    <div class="price"><ins>TK:1,400.00</ins><del>TK:1800.00</del></div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 cate-p">
                              <div class="thumbnail no-border no-padding">
                                 <div class="media">
                                    <img class="img-sl" src="assets/img/s3.png" alt=""/>
                                    <button class="btn orange-bg view-btn"  data-toggle="modal" data-target="#addcart"><i class="fa-regular fa-eye"></i></button>
                                 </div>
                                 <div class="caption text-center">
                                    <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                                    <p class="p-title">Brand Name</p>
                                    <div class="price"><ins>TK:1,400.00</ins><del>TK:1800.00</del></div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 cate-p">
                              <div class="thumbnail no-border no-padding">
                                 <div class="media">
                                    <img class="img-sl" src="assets/img/s4.png" alt=""/>
                                    <button class="btn orange-bg view-btn"  data-toggle="modal" data-target="#addcart"><i class="fa-regular fa-eye"></i></button>
                                 </div>
                                 <div class="caption text-center">
                                    <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                                    <p class="p-title">Brand Name</p>
                                    <div class="price"><ins>TK:1,400.00</ins></div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 cate-p">
                              <div class="thumbnail no-border no-padding">
                                 <div class="media">
                                    <img class="img-sl" src="assets/img/s5.png" alt=""/>
                                    <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i class="fa-regular fa-eye"></i></button>
                                 </div>
                                 <div class="caption text-center">
                                    <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                                    <p class="p-title">Brand Name</p>
                                    <div class="price"><ins>TK:1,400.00</ins></div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 cate-p">
                              <div class="thumbnail no-border no-padding">
                                 <div class="media">
                                    <img class="img-sl" src="assets/img/l1.png" alt=""/>
                                    <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i class="fa-regular fa-eye"></i></button>
                                 </div>
                                 <div class="caption text-center">
                                    <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                                    <p class="p-title">Brand Name</p>
                                    <div class="price"><ins>TK:1,400.00</ins></div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 cate-p">
                              <div class="thumbnail no-border no-padding">
                                 <div class="media">
                                    <img class="img-sl" src="assets/img/l2.png" alt=""/>
                                    <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i class="fa-regular fa-eye"></i></button>
                                 </div>
                                 <div class="caption text-center">
                                    <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                                    <p class="p-title">Brand Name</p>
                                    <div class="price"><ins>TK:1,400.00</ins></div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 cate-p">
                              <div class="thumbnail no-border no-padding">
                                 <div class="media">
                                    <img class="img-sl" src="assets/img/l3.png" alt=""/>
                                    <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i class="fa-regular fa-eye"></i></button>
                                 </div>
                                 <div class="caption text-center">
                                    <h4 class="caption-title"><a href="product-details.html">Standard Product Header</a></h4>
                                    <p class="p-title">Brand Name</p>
                                    <div class="price"><ins>TK:1,400.00</ins></div>
                                 </div>
                              </div>
                           </div>
                           <!-- end Related Products  -->
                        </div>
                        <!-- /Products grid -->
                        <!-- Pagination -->
                        <div class="pagination-wrapper text-center">
                           <ul class="pagination">
                              <li class=""><a href="#"><i class="fa fa-angle-double-left"></i> </a></li>
                              <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                              <li><a href="#">2</a></li>
                              <li><a href="#">3</a></li>
                              <li><a href="#">4</a></li>
                              <li><a href="#"> <i class="fa fa-angle-double-right"></i></a></li>
                           </ul>
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

@push('js') @endpush
