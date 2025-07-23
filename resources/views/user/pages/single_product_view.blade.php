<div class="row product-single">
    <input type="hidden" id="product-id" value="{{ $product->id }}">
    <div class="col-md-6">
        <div class="owl-carousel img-carousel img-carousel2">
            @foreach($product['images'] as $image)
                <div class="item">
                    <a class="btn btn-theme btn-theme-transparent btn-zoom" href="{{ asset($image->image_path) }}"
                       data-gal="prettyPhoto"><i class="fa fa-plus"></i></a>
                    <a href="{{ asset($image->image_path) }}" data-gal="prettyPhoto">
                        <img class="img-responsive" src="{{ asset($image->image_path) }}" alt=""/></a>
                </div>
            @endforeach
        </div>
        <div class="row product-thumbnails">
            @foreach($product['images'] as $image)
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
            <span class="link">
                <i class="fa fa-angle-left"></i> Back to
                <a href="{{ route('product-lists', ['category' => $product->category->slug]) }}">{{ $product->category->name ?? '' }}</a>
            </span>
        </div>
        <div class="brand-name">
            <a href="">  {{ $product->brand->name ?? '' }}</a>
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
        <div class="product-text ">
            {!! $product->short_description ?? '' !!}
        </div>
        <hr class="page-divider"/>
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
                                <span style="background-color: {{ $variant->color->color_code ?? '#FF6E40' }}" title="{{ $variant->color_name ?? '' }}"></span>
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
        <hr class="page-divider"/>
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
            <button class="btn btn-theme btn-wish-list btn-cart-m add-to-wishlist" type="button" data-product-id="{{ encrypt_decrypt($product->id,'encrypt') }}">
                <i class="fa-regular fa-heart orange-text"></i>
            </button>
        </div>
        <hr class="page-divider small"/>
    </div>
</div>

