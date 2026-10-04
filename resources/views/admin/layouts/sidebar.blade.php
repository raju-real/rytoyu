{{-- Sidebar styles are in assets/admin/css/custom.css --}}

<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                <i class="bx bx-home-circle"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- To-Do --}}
        <li class="{{ Route::is('admin.todos.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.todos.index') }}"
                class="waves-effect {{ Route::is('admin.todos.*') ? 'active' : '' }}">
                <i class="bx bx-task"></i>
                <span>To-Do List</span>
            </a>
        </li>

        {{-- Expense Management --}}
        <li class="{{ Route::is('admin.expenses.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.expenses.index') }}"
                class="waves-effect {{ Route::is('admin.expenses.*') ? 'active' : '' }}">
                <i class="bx bx-wallet"></i>
                <span>Expenses</span>
            </a>
        </li>

        {{-- Notifications --}}
        <li class="{{ Route::is('admin.notifications.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.notifications.index') }}"
                class="waves-effect {{ Route::is('admin.notifications.*') ? 'active' : '' }}">
                <i class="bx bx-bell"></i>
                <span>Notifications</span>
            </a>
        </li>

        @if (Auth::guard('admin')->user()->hasPermissionTo('manage_products'))
            <li class="{{ isMainMenuActive('products') }}">
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bxl-product-hunt"></i>
                    <span>Products</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.products.index') }}"
                            class="{{ Route::is('admin.products.index') ? 'active mm-active' : '' }}">
                            <i class="bx bx-chevron-right"></i> Product List
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.create') }}"
                            class="{{ Route::is('admin.products.create') ? 'active mm-active' : '' }}">
                            <i class="bx bx-chevron-right"></i> Add Product
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if (authAdminType() !== 'seller')
            @if (Auth::guard('admin')->user()->hasPermissionTo('manage_orders'))
                <li class="{{ isMainMenuActive('manage-orders,commission-logs,order-summary,change-order-status') }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cart"></i>
                        <span>Manage Order</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.manage-orders') }}"
                                class="{{ Route::is('admin.manage-orders') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Order List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.commission-logs') }}"
                                class="{{ Route::is('admin.commission-logs') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Commission Logs
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->hasPermissionTo('manage_webpage'))
                <li
                    class="{{ isMainMenuActive('sliders,announcements,new-in-products,manage-product-types,latest-offers') }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span>Web Page Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.sliders.index') }}"
                                class="{{ Route::is('admin.sliders.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Sliders
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.announcements.index') }}"
                                class="{{ Route::is('admin.announcements.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Announcements
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.new-in-products') }}"
                                class="{{ Route::is('admin.new-in-products') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> New In
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.manage-product-types') }}"
                                class="{{ Route::is('admin.manage-product-types') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Product Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.latest-offers') }}"
                                class="{{ Route::is('admin.latest-offers') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Latest Offer
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->hasPermissionTo('manage_attributes'))
                <li
                    class="{{ isMainMenuActive('categories,subcategories,sub-subcategories,brands,sizes,colors,units,tags,product-types') }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-list-check"></i>
                        <span>Attributes</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.product-types.index') }}"
                                class="{{ Route::is('admin.product-types.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Product Type
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.index') }}"
                                class="{{ Route::is('admin.categories.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Category
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.subcategories.index') }}"
                                class="{{ Route::is('admin.subcategories.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Sub Category
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.sub-subcategories.index') }}"
                                class="{{ Route::is('admin.sub-subcategories.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Sub Subcategory
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.brands.index') }}"
                                class="{{ Route::is('admin.brands.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Brand
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.sizes.index') }}"
                                class="{{ Route::is('admin.sizes.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Size
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.colors.index') }}"
                                class="{{ Route::is('admin.colors.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Color
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.units.index') }}"
                                class="{{ Route::is('admin.units.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Unit
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tags.index') }}"
                                class="{{ Route::is('admin.tags.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Tag
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::guard('admin')->user()->hasPermissionTo('manage_sellers') ||
                    Auth::guard('admin')->user()->hasPermissionTo('manage_refunds'))
                <li class="{{ isMainMenuActive('sellers,seller-products,seller-product') }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user-plus"></i>
                        <span>Sellers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if (Auth::guard('admin')->user()->hasPermissionTo('manage_sellers'))
                            <li>
                                <a href="{{ route('admin.sellers.index') }}"
                                    class="{{ Route::is('admin.sellers.index') ? 'active mm-active' : '' }}">
                                    <i class="bx bx-chevron-right"></i> Seller List
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.sellers.create') }}"
                                    class="{{ Route::is('admin.sellers.create') ? 'active mm-active' : '' }}">
                                    <i class="bx bx-chevron-right"></i> Add Seller
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.seller-products') }}"
                                    class="{{ Route::is('admin.seller-products') ? 'active mm-active' : '' }}">
                                    <i class="bx bx-chevron-right"></i> Product List
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.vendor-payouts') }}"
                                    class="{{ Route::is('admin.vendor-payouts') ? 'active mm-active' : '' }}">
                                    <i class="bx bx-chevron-right"></i> Payout Requests
                                </a>
                            </li>
                        @endif
                        @if (Auth::guard('admin')->user()->hasPermissionTo('manage_refunds'))
                            <li>
                                <a href="{{ route('admin.refund-requests') }}"
                                    class="{{ Route::is('admin.refund-requests') ? 'active mm-active' : '' }}">
                                    <i class="bx bx-chevron-right"></i> Refund Requests
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->hasPermissionTo('manage_admins'))
                <li class="{{ isMainMenuActive('roles,admin-users') }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-shield-quarter"></i>
                        <span>Staff / Roles</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.admin-users.index') }}"
                                class="{{ Route::is('admin.admin-users.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Manage Admins
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.roles.index') }}"
                                class="{{ Route::is('admin.roles.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Manage Roles
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->hasPermissionTo('manage_coupons'))
                <li class="{{ isMainMenuActive('coupons') }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class='bx  bx-laugh'></i>
                        <span>Coupon</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.coupons.index') }}"
                                class="{{ Route::is('admin.coupons.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Coupon List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.coupons.create') }}"
                                class="{{ Route::is('admin.coupons.create') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Add Coupon
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->hasPermissionTo('manage_reports'))
                <li class="{{ isMainMenuActive('reports.sales,reports.commission') }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class='bx bx-bar-chart-alt-2'></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.reports.sales') }}"
                                class="{{ Route::is('admin.reports.sales') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Sales Report
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.reports.commission') }}"
                                class="{{ Route::is('admin.reports.commission') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Commission Report
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->hasPermissionTo('manage_settings'))
                <li
                    class="{{ isMainMenuActive('site-settings,payment-settings,courier-settings,delivery-charges,faqs') }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.site-settings') }}"
                                class="{{ Route::is('admin.site-settings') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Site Settings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.payment-settings') }}"
                                class="{{ Route::is('admin.payment-settings') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Payment Settings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.courier-settings') }}"
                                class="{{ Route::is('admin.courier-settings') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Courier Settings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.delivery-charges.index') }}"
                                class="{{ Route::is('admin.delivery-charges.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Delivery Charges
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.faqs.index') }}"
                                class="{{ Route::is('admin.faqs.index') ? 'active mm-active' : '' }}">
                                <i class="bx bx-chevron-right"></i> Faqs
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @endif

        @if (authAdminType() === 'seller')
            <li>
                <a href="{{ route('admin.seller-orders') }}" class="waves-effect">
                    <i class="bx bx-home-circle"></i>
                    <span>Order List</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.my-payouts') }}" class="waves-effect">
                    <i class="bx bx-money"></i>
                    <span>My Payouts</span>
                </a>
            </li>
        @endif
    </ul>
</div>
