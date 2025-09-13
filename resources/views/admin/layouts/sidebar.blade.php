<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                <i class="bx bx-home-circle"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="{{ isMainMenuActive('products') }}">
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bxl-product-hunt"></i>
                <span>Products</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('admin.products.index') }}" class="{{ isSubMenuActive('products') }}">
                        <i class="bx bx-chevron-right"></i> Product List
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.create') }}" class="{{ isSubMenuActive('products') }}">
                        <i class="bx bx-chevron-right"></i> Add Product
                    </a>
                </li>
            </ul>
        </li>
        @if(authAdminType() !== 'seller')
            <li class="{{ isMainMenuActive('manage-orders,commission-logs,order-summary,change-order-status') }}">
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-cart"></i>
                    <span>Manage Order</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.manage-orders') }}"
                           class="{{ isSubMenuActive('manage-orders,order-summary,change-order-status') }}">
                            <i class="bx bx-chevron-right"></i> Order List
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.commission-logs') }}" class="{{ isSubMenuActive('commission-logs') }}">
                            <i class="bx bx-chevron-right"></i> Commission Logs
                        </a>
                    </li>

                </ul>
            </li>

            <li class="{{ isMainMenuActive('sections') }}">
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-layout"></i>
                    <span>Web Page Manage</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.sliders.index') }}" class="{{ isSubMenuActive('sliders') }}">
                            <i class="bx bx-chevron-right"></i> Sliders
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.announcements.index') }}"
                           class="{{ isSubMenuActive('announcements') }}">
                            <i class="bx bx-chevron-right"></i> Announcements
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.new-in-products') }}" class="{{ isSubMenuActive('new-in-products') }}">
                            <i class="bx bx-chevron-right"></i> New In
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.manage-product-types') }}"
                           class="{{ isSubMenuActive('manage-product-types') }}">
                            <i class="bx bx-chevron-right"></i> Product Types
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.latest-offers') }}" class="{{ isSubMenuActive('latest-offers') }}">
                            <i class="bx bx-chevron-right"></i> Latest Offer
                        </a>
                    </li>

                </ul>
            </li>

            <li class="{{ isMainMenuActive('categories,subcategories,sub-subcategories,brands,sizes,colors,units,tags,product-types') }}">
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-list-check"></i>
                    <span>Attributes</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.product-types.index') }}"
                           class="{{ isSubMenuActive('product-types') }}">
                            <i class="bx bx-chevron-right"></i> Product Type
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="{{ isSubMenuActive('categories') }}">
                            <i class="bx bx-chevron-right"></i> Category
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.subcategories.index') }}"
                           class="{{ isSubMenuActive('subcategories') }}">
                            <i class="bx bx-chevron-right"></i> Sub Category
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.sub-subcategories.index') }}"
                           class="{{ isSubMenuActive('sub-subcategories') }}">
                            <i class="bx bx-chevron-right"></i> Sub Subcategory
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.brands.index') }}" class="{{ isSubMenuActive('brands') }}">
                            <i class="bx bx-chevron-right"></i> Brand
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.sizes.index') }}" class="{{ isSubMenuActive('sizes') }}">
                            <i class="bx bx-chevron-right"></i> Size
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.colors.index') }}" class="{{ isSubMenuActive('colors') }}">
                            <i class="bx bx-chevron-right"></i> Color
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.units.index') }}" class="{{ isSubMenuActive('units') }}">
                            <i class="bx bx-chevron-right"></i> Unit
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.tags.index') }}" class="{{ isSubMenuActive('tags') }}">
                            <i class="bx bx-chevron-right"></i> Tag
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ isMainMenuActive('sellers,seller-products,seller-product') }}">
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-user-plus"></i>
                    <span>sellers</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.sellers.index') }}"
                           class="{{ isSubMenuActive('sellers') }}">
                            <i class="bx bx-chevron-right"></i> Seller List
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.sellers.create') }}"
                           class="{{ isSubMenuActive('sellers') }}">
                            <i class="bx bx-chevron-right"></i> Add Seller
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.seller-products') }}"
                           class="{{ isSubMenuActive('seller-products,seller-product') }}">
                            <i class="bx bx-chevron-right"></i> Product List
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{ isMainMenuActive('coupons') }}">
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class='bx  bx-laugh'></i>
                    <span>Coupon</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.coupons.index') }}" class="{{ isSubMenuActive('coupons') }}">
                            <i class="bx bx-chevron-right"></i> Coupon List
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.coupons.create') }}" class="{{ isSubMenuActive('coupons') }}">
                            <i class="bx bx-chevron-right"></i> Add Coupon
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{ isMainMenuActive('site-settings,delivery-charges,faqs') }}">
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-cog"></i>
                    <span>Settings</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.site-settings') }}" class="{{ isSubMenuActive('site-settings') }}">
                            <i class="bx bx-chevron-right"></i> Site Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.delivery-charges.index') }}"
                           class="{{ isSubMenuActive('delivery-charges') }}">
                            <i class="bx bx-chevron-right"></i> Delivery Charges
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.faqs.index') }}"
                           class="{{ isSubMenuActive('faqs') }}">
                            <i class="bx bx-chevron-right"></i> Faqs
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(authAdminType() === 'seller')
            <li>
                <a href="{{ route('admin.seller-orders') }}" class="waves-effect">
                    <i class="bx bx-home-circle"></i>
                    <span>Order List</span>
                </a>
            </li>
        @endif
    </ul>
</div>
