@extends('user.layouts.app')
@section('title',$product->name ?? 'Product Details')
@push('css') @endpush

@section('content')
    <!-- PAGE -->
    <section class="page-section">
        <div class="container">
            <input type="hidden" id="product-id" value="{{ $product->id }}">
            <div class="row product-single">
                <div class="col-md-6">
                    <div class="owl-carousel img-carousel img-carousel3">
                        @foreach($product->images as $image)
                            <div class="item">
                                <a class="btn btn-theme btn-theme-transparent btn-zoom"
                                   href="{{ asset($image->image_path) }}" data-gal="prettyPhoto"><i
                                        class="fa fa-plus"></i></a>
                                <a href="{{ asset($image->image_path) }}" data-gal="prettyPhoto"><img
                                        class="img-responsive" src="{{ asset($image->image_path) }}" alt=""/></a>
                            </div>
                        @endforeach
                    </div>
                    <div class="row product-thumbnails">
                        @foreach($product->images as $image)
                            <div class="col-xs-2 col-sm-2 col-md-3">
                                <a href="#" onclick="jQuery('.img-carousel').trigger('to.owl.carousel', [0, 300]);">
                                    <img src="{{ asset($image->image_path) }}" alt=""/>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="back-to-category">
                        <span class="link"><i class="fa fa-angle-left"></i> Back to <a
                                href="category.html">{{ $product->category->name ?? '' }}</a></span>
                    </div>
                    <div class="brand-name">
                        <a href=""> {{ $product->brand->name ?? '' }}</a>
                    </div>
                    <h2 class="product-title">{{ $product->name ?? '' }}</h2>
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
                    <div class="product-availability">Availability:
                        <strong id="stock-status">{{ $product->default_variant->stock_status ?? '' }}</strong>
                        <span id="inventory">{{ $product->default_variant->inventory ?? '' }}</span> Item(s)
                    </div>
                    <div class="product-price" id="product-price-sec"> TK:
                        @if($product->default_variant->discount_price > 0)
                            <span id="unit-price">{{ $product->default_variant->discount_price ?? 0 }}</span>
                            <span id="discount-price"><del>{{ $product->default_variant->unit_price ?? 0 }}</del></span>
                        @else
                            <span id="unit-price">{{ $product->default_variant->unit_price ?? 0 }}</span>
                        @endif
                    </div>
                    <hr class="page-divider"/>
                    <div class="product-text font-de-produ">
                        {!! $product->short_description ?? '' !!}
                    </div>
                    <hr class="page-divider"/>
                    <div class="row">
                        <div class="col-md-7 p-d-left">
                            <h4 class="color-list">Color: <span></span></h4>
                            <div class="widget widget-colors">
                                <ul>
                                    @foreach($product->variants as $variant)
                                        <li>
                                            <div class="size-list-color">
                                                <input id="radio-col-{{ $variant->id }}"
                                                       class="radio-custom color-radio"
                                                       name="color"
                                                       value="{{ $variant->color_id }}"
                                                       type="radio"
                                                    {{ $product->default_variant->color_id == $variant->color_id ? 'checked' : '' }}>
                                                <label for="radio-col-{{ $variant->id }}" class="radio-custom-label">
                                                    <span
                                                        style="background-color: {{ $variant->color->color_code ?? '#FF6E40' }}"
                                                        title="{{ $variant->color_name ?? '' }}"></span>
                                                </label>
                                            </div>

                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <h4 class="color-list margin-size">Size: <span></span></h4>
                            <ul class="size-shop">
                                @foreach($product->variants as $variant)
                                    <li>

                                        <div class="size-list">
                                            <input id="radio-xs-{{ $variant->id }}"
                                                   class="radio-custom size-radio"
                                                   name="sizesa"
                                                   value="{{ $variant->size_id }}"
                                                   type="radio"
                                                {{ $product->default_variant->size_id == $variant->size_id ? 'checked' : '' }}>
                                            <label for="radio-xs-{{ $variant->id }}" class="radio-custom-label">
                                                <span>{{ $variant->size_name ?? '' }}</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-5 pr-0">
                            {!! $product->product_specification ?? '' !!}
                        </div>
                    </div>
                    <hr class="page-divider  mt-0"/>
                    <div class="buttons" id="cart-add">
                        <div class="quantity">
                            <button class="btn qty-btn" data-type="minus"><i class="fa fa-minus"></i></button>
                            <input class="form-control qty" type="number" step="1" min="1" name="quantity" value="1"
                                   title="Qty">
                            <button class="btn qty-btn" data-type="plus"><i class="fa fa-plus"></i></button>
                        </div>
                        <button class="btn btn-theme btn-cart btn-icon-left add-t-c-2" type="button"
                                data-product-id="{{ $product->id }}">
                            <i class="fa fa-shopping-cart"></i> Add to cart
                        </button>
                        <button class="btn btn-theme btn-wish-list btn-cart-m"><i
                                class="fa-regular fa-heart orange-text"></i></button>
                        <button class="btn btn-theme btn-compare btn-cart-m"><i class="fa fa-exchange"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /PAGE -->
    <!--Related Products -->
    <section class="page-section col-md-12 p-0">
        <div class="container-fluid p-0">
            <h2 class="section-title"><span>Related Products</span></h2>
            <div class="top-products-carousel mt-p-all">
                <div class="owl-carousel slider-c-custom" id="top-products-carouselt">
                    @foreach($related_products as $product)
                        <div class="thumbnail no-border no-padding">
                            <div class="media">
                                <img class="img-sl" src="{{ asset($product->thumbnail_path) }}" alt=""/>
                                <button class="btn orange-bg view-btn" data-toggle="modal" data-target="#addcart"><i
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
        <!--     <div class="container">
               <div class="col-md-12 text-center">
                  <button class="btn bule-bg btn-review"> VIEW MORE</button>
               </div>
            </div> -->
    </section>
    <!-- end Related Products  -->

    <div class="clearfix"></div>
    <!-- /CONTENT AREA -->
    <div class="container border-top mt-40">
        <div class="col-md-12">
            <ul class="review-ul">
                <li>
                    <div class="review-left">
                        <h4>Masud Ahmed</h4>
                        <p>Dhaka, Bangladesh</p>
                        <span>12-01-2025</span>
                    </div>
                    <div class="review-right">
                        <div class="review-start">
                            <div class="product-rating clearfix">
                                <div class="rating">
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                </div>
                            </div>
                        </div>
                        <h5>Wow</h5>
                        <p>I love this hoodie so much! It definitely runs on the larger side. Also PLEASE make more
                            colors I NEED!!</p>
                        <span class="span-r">Size Purchased: Small</span>
                        <span class="span-r">Size Normally Worn: Small-Medium</span>
                        <span class="span-r">Yes, I recommend this product.</span>
                    </div>
                </li>
                <li>
                    <div class="review-left">
                        <h4>Shakil Khan</h4>
                        <p>Dhaka, Bangladesh</p>
                        <span>12-01-2025</span>
                    </div>
                    <div class="review-right">
                        <div class="review-start">
                            <div class="product-rating clearfix">
                                <div class="rating">
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                </div>
                            </div>
                        </div>
                        <h5>Wow</h5>
                        <p>I love this hoodie so much! It definitely runs on the larger side. Also PLEASE make more
                            colors I NEED!!</p>
                        <span class="span-r">Size Purchased: Small</span>
                        <span class="span-r">Size Normally Worn: Small-Medium</span>
                        <span class="span-r">Yes, I recommend this product.</span>
                    </div>
                </li>
                <li>
                    <div class="review-left">
                        <h4>Sumon</h4>
                        <p>Dhaka, Bangladesh</p>
                        <span>12-01-2025</span>
                    </div>
                    <div class="review-right">
                        <div class="review-start">
                            <div class="product-rating clearfix">
                                <div class="rating">
                                    <span class="star"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                </div>
                            </div>
                        </div>
                        <h5>Wow</h5>
                        <p>I love this hoodie so much! It definitely runs on the larger side. Also PLEASE make more
                            colors I NEED!!</p>
                        <span class="span-r">Size Purchased: Small</span>
                        <span class="span-r">Size Normally Worn: Small-Medium</span>
                        <span class="span-r">Yes, I recommend this product.</span>
                    </div>
                </li>
            </ul>
            <div class="col-md-12 text-center">
                <button class="btn w-review">Write Review</button>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="review-box">
            <label>ADD A REVIEW</label>
            <textarea class="form-control" rows="8" placeholder="Your message"></textarea>
            <button class="btn orange-bg"><i class="fa-solid fa-comment-dots"></i>REVIEW</button>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/user/js/product-details.js') }}"></script>
@endpush
