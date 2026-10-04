<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" base_url="{!! url('/') !!}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="shortcut icon" href="{{ asset(siteSettings()['favicon'] ?? ecommerceIcon()) }}">
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/js/jquery_ui/jquery-ui.css') }}" />
    {{-- Datetimepicker --}}
    <link rel="stylesheet" href="{{ asset('assets/common/datetimepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/common/datetimepicker/css/tempusdominus-bootstrap-4.min.css') }}"
        crossorigin="anonymous" />

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/custom.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    @stack('css')
</head>

<body data-sidebar="light" data-layout-mode="light" data-topbar="light">
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>

    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="{{ route('home') }}" target="_blank" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset(siteSettings()['favicon'] ?? ecommerceIcon()) }}" alt=""
                                    height="50">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset(siteSettings()['logo'] ?? devLogo()) }}" alt=""
                                    height="50">
                            </span>
                        </a>

                        <a href="{{ route('home') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset(siteSettings()['favicon'] ?? ecommerceIcon()) }}" alt=""
                                    height="50">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset(siteSettings()['logo'] ?? devLogo()) }}" alt=""
                                    height="50">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    {{-- Quick Action Buttons --}}
                    <div class="d-flex align-items-center gap-1 ms-2">
                        {{-- My Store --}}
                        <a class="topbar-quick-btn" href="{{ route('admin.shop-info') }}" data-bs-toggle="tooltip"
                            title="My Store">
                            <i class="bx bx-store"></i>
                        </a>
                        {{-- To-Do --}}
                        <a class="topbar-quick-btn" href="{{ route('admin.todos.index') }}" data-bs-toggle="tooltip"
                            title="To-Do List">
                            <i class="bx bx-task"></i>
                            @php $pendingTodos = \App\Models\Todo::where('admin_id', authAdmin()->id)->where('status','pending')->count(); @endphp
                            @if ($pendingTodos > 0)
                                <span class="btn-badge" title="{{ $pendingTodos }} pending"></span>
                            @endif
                        </a>
                        {{-- Expenses --}}
                        <a class="topbar-quick-btn" href="{{ route('admin.expenses.index') }}"
                            data-bs-toggle="tooltip" title="Expense Management">
                            <i class="bx bx-wallet"></i>
                        </a>
                    </div>

                </div>

                <div class="d-flex">

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            data-bs-toggle="fullscreen">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>

                    {{-- LIVE Notifications Bell --}}
                    <div class="dropdown d-inline-block" id="notification-dropdown-wrapper">
                        <button type="button" class="btn header-item noti-icon waves-effect position-relative"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-bell bx-tada"></i>
                            <span id="notification-badge" class="d-none">0</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown" style="min-width:360px;">
                            <div class="p-3 d-flex align-items-center justify-content-between border-bottom">
                                <h6 class="m-0 fw-bold"><i class="bx bx-bell me-2"
                                        style="color:var(--color-primary)"></i>Notifications</h6>
                                <div class="d-flex gap-2">
                                    <a href="javascript:void(0)" id="mark-all-read"
                                        class="btn btn-sm btn-soft-primary py-1 px-2" style="font-size:11px;">Mark all
                                        read</a>
                                    <a href="{{ route('admin.notifications.index') }}"
                                        class="btn btn-sm btn-soft-info py-1 px-2" style="font-size:11px;">View
                                        All</a>
                                </div>
                            </div>
                            <div id="notification-list" style="max-height:320px; overflow-y:auto;">
                                <div class="text-center py-3 text-muted" id="notif-loading">
                                    <i class="bx bx-loader bx-spin"></i> Loading…
                                </div>
                            </div>
                            <div class="p-2 border-top text-center" id="notif-load-more-wrapper"
                                style="display:none;">
                                <button class="btn btn-sm btn-soft-primary w-100" id="notif-load-more">Load
                                    more</button>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset(authAdmin()->image ?? userAvatar()) }}" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1">{{ authAdmin()->name ?? 'Admin' }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <i class="bx bx-user font-size-16 align-middle me-1"></i>
                                <span>Profile</span>
                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                                <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                @include('admin.layouts.sidebar')
            </div>
        </div>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @if (!authAdmin()->mobile_verified_at)
                                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center"
                                    role="alert">
                                    <i class="mdi mdi-alert-circle-outline me-2"></i>
                                    <span class="flex-grow-1">
                                        Your mobile number is not verified yet. Please
                                        <a href="{{ route('admin.mobile-verification') }}"
                                            class="alert-link text-decoration-underline">click here</a>
                                        to verify now and ensure uninterrupted access to our services.
                                    </span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (!authAdmin()->email_verified_at)
                                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center"
                                    role="alert">
                                    <i class="mdi mdi-alert-circle-outline me-2"></i>
                                    <span class="flex-grow-1">
                                        Your email is not verified yet. Please
                                        <a href="{{ route('admin.mobile-verification') }}"
                                            class="alert-link text-decoration-underline">click here</a>
                                        to verify now and ensure uninterrupted access to our services.
                                    </span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                        </div>

                    </div>
                    <x-dismissible-alert></x-dismissible-alert>
                    @yield('content')
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                SV ECOMMERCE
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Some common modal --}}
    {{-- Image preview modal --}}
    <div class="modal fade" id="viewImageModal" tabindex="-1" aria-labelledby="viewImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewImageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Image Preview" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Data view modal --}}
    <div class="modal fade" id="data-view-modal" tabindex="-1" aria-labelledby="dataViewModal" aria-hidden="true">
        <div class="modal-dialog" id="data-view-modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title data-view-modal-header" id="dataViewModal"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="data-view-modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Scripts --}}
    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('assets/admin/js/axios.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery_ui/jquery-ui.min.js') }}"></script>
    {{-- Datetimepicker --}}
    <script src="{{ asset('assets/common/datetimepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/common/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/common/datetimepicker/js/moment-timezone-with-data.min.js') }}"></script>
    <script src="{{ asset('assets/common/datetimepicker/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/common/datetimepicker/js/custom_picker.js') }}"></script>
    // Custom created js
    <script src="{{ asset('assets/admin/js/helpers.js') }}"></script>
    // Page wise js
    <script src="{{ asset('assets/admin/js/common.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>

    <script>
        (function() {
            /* ═══════════════════════════════════════════════════════
               1. SIDEBAR COLLAPSE  — localStorage persisted
               ═══════════════════════════════════════════════════════ */
            var SIDEBAR_KEY = 'rytoyu_sidebar_collapsed';
            var body = document.body;
            var togBtn = document.getElementById('vertical-menu-btn');

            // Restore state on load
            if (localStorage.getItem(SIDEBAR_KEY) === '1') {
                body.classList.add('sidebar-collapsed');
            }

            if (togBtn) {
                togBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem(SIDEBAR_KEY, body.classList.contains('sidebar-collapsed') ? '1' : '0');
                });
            }

            /* ═══════════════════════════════════════════════════════
               2. TOOLTIPS  — global init + mutation observer
               ═══════════════════════════════════════════════════════ */
            function initTooltips(root) {
                root = root || document;
                [].slice.call(root.querySelectorAll('[data-bs-toggle="tooltip"]')).forEach(function(el) {
                    // Avoid double-init
                    if (el._tooltipInitialized) return;
                    el._tooltipInitialized = true;
                    var tt = new bootstrap.Tooltip(el, {
                        trigger: 'hover focus',
                        boundary: 'window',
                        placement: el.getAttribute('data-bs-placement') || 'top',
                        html: false
                    });
                });
            }

            // Init on DOM ready
            document.addEventListener('DOMContentLoaded', function() {
                initTooltips();
            });

            // Also init now (for elements already in DOM at script execution time)
            initTooltips();

            // Watch for dynamically added elements
            if (typeof MutationObserver !== 'undefined') {
                var obs = new MutationObserver(function(mutations) {
                    mutations.forEach(function(m) {
                        m.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1) {
                                // Node itself
                                if (node.getAttribute && node.getAttribute('data-bs-toggle') ===
                                    'tooltip') {
                                    initTooltips(node.parentNode || document);
                                }
                                // Its children
                                if (node.querySelectorAll) {
                                    initTooltips(node);
                                }
                            }
                        });
                    });
                });
                obs.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            }

            /* ═══════════════════════════════════════════════════════
               3. LIVE NOTIFICATIONS
               ═══════════════════════════════════════════════════════ */
            var notifPage = 1;
            var notifLoading = false;
            var NOTIF_URL = '{{ route('admin.notifications.fetch') }}';
            var MARK_URL = '{{ route('admin.notifications.mark-read') }}';
            var CSRF = '{{ csrf_token() }}';

            function renderNotif(n) {
                var iconMap = {
                    order: 'bx-cart',
                    seller: 'bx-store',
                    refund: 'bx-undo',
                    system: 'bx-info-circle'
                };
                var icon = iconMap[n.type] || 'bx-bell';
                var cls = n.is_read ? '' : 'unread';
                return '<div class="notification-item ' + cls + '" data-id="' + n.id + '" data-url="' + (n.url || '#') +
                    '" style="cursor:pointer">' +
                    '<div class="notif-icon"><i class="bx ' + icon + '"></i></div>' +
                    '<div class="notif-body flex-grow-1"><p class="mb-0">' + n.message + '</p><small>' + n.time_ago +
                    '</small></div>' +
                    '</div>';
            }

            function loadNotifications(reset) {
                if (notifLoading) return;
                if (reset) {
                    notifPage = 1;
                    $('#notification-list').html(
                        '<div class="text-center py-3 text-muted" id="notif-loading"><i class="bx bx-loader bx-spin"></i> Loading…</div>'
                    );
                }
                notifLoading = true;
                $.ajax({
                    url: NOTIF_URL + '?page=' + notifPage,
                    method: 'GET',
                    success: function(res) {
                        if (reset) $('#notification-list').empty();
                        if (res.data && res.data.length) {
                            res.data.forEach(function(n) {
                                $('#notification-list').append(renderNotif(n));
                            });
                        } else if (notifPage === 1) {
                            $('#notification-list').html(
                                '<div class="text-center py-4 text-muted"><i class="bx bx-check-circle" style="font-size:2rem;display:block;margin-bottom:6px;"></i>No new notifications</div>'
                            );
                        }
                        var cnt = res.total_unread || 0;
                        if (cnt > 0) {
                            $('#notification-badge').text(cnt > 99 ? '99+' : cnt).removeClass('d-none');
                        } else {
                            $('#notification-badge').addClass('d-none');
                        }
                        res.has_more ? $('#notif-load-more-wrapper').show() : $('#notif-load-more-wrapper')
                            .hide();
                        notifPage++;
                    },
                    error: function() {
                        if (reset) $('#notification-list').html(
                            '<div class="text-center py-3 text-danger">Failed to load notifications</div>'
                        );
                    },
                    complete: function() {
                        notifLoading = false;
                    }
                });
            }

            $('#page-header-notifications-dropdown').on('click', function() {
                loadNotifications(true);
            });
            $(document).on('scroll', '#notification-list', function() {
                if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight - 20) loadNotifications(
                    false);
            });
            $(document).on('click', '#notif-load-more', function() {
                loadNotifications(false);
            });
            $(document).on('click', '#mark-all-read', function() {
                $.post(MARK_URL, {
                    _token: CSRF
                }, function() {
                    loadNotifications(true);
                });
            });
            $(document).on('click', '.notification-item', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                $(this).removeClass('unread');
                $.post(MARK_URL, {
                    _token: CSRF,
                    id: id
                });
                if (url && url !== '#') window.location.href = url;
            });

            // Poll badge count every 60s
            setInterval(function() {
                $.getJSON(NOTIF_URL + '?page=1&count_only=1', function(res) {
                    var cnt = res.total_unread || 0;
                    cnt > 0 ? $('#notification-badge').text(cnt > 99 ? '99+' : cnt).removeClass(
                            'd-none') :
                        $('#notification-badge').addClass('d-none');
                });
            }, 60000);
        })();
    </script>

    @stack('js')
</body>

</html>
