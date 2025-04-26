<div class="row product-single">
                    <div class="col-md-6">
                        <div class="owl-carousel img-carousel img-carousel2">
                            @foreach($product['images'] as $image)
                            <div class="item">
                                <a class="btn btn-theme btn-theme-transparent btn-zoom" href="{{ asset($image->image_path) }}"
                                   data-gal="prettyPhoto"><i class="fa fa-plus"></i></a>
                                <a href="{{ asset($image->image_path) }}" data-gal="prettyPhoto"><img class="img-responsive"
                                                                                             src="{{ asset($image->image_path) }}"
                                                                                             alt=""/></a>
                            </div>
                            @endforeach
                        </div>
                        <div class="row product-thumbnails">
                            @foreach($product['images'] as $image)
                            <div class="col-xs-2 col-sm-2 col-md-3"><a href="#"
                                                                       onclick="jQuery('.img-carousel').trigger('to.owl.carousel', [0, 300]);"><img
                                        src="{{ asset($image->image_path) }}" alt=""/></a>
                            </div>
                            @endforeach
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
