@extends('admin.layouts.app')
@section('title', 'Manage Orders')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Manage Orders</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Accordion for Search -->
            <div class="accordion mb-3" id="accordionSearch">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSearch">
                        <button class="accordion-button {{ request()->query() ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseSearch"
                            aria-expanded="{{ request()->query() ? 'true' : 'false' }}" aria-controls="collapseSearch">
                            Search
                        </button>
                    </h2>
                    <div id="collapseSearch" class="accordion-collapse collapse {{ request()->query() ? 'show' : '' }}"
                        aria-labelledby="headingSearch" data-bs-parent="#accordionSearch">
                        <div class="accordion-body">
                            <form method="GET" action="{{ route('admin.manage-orders') }}">
                                <div class="row">
                                    <div class="col-md-6 pb-4">
                                        <div class="form-group">
                                            <input type="search" name="search" class="form-control"
                                                placeholder="Search by Order Number,Invoice,Mobile"
                                                value="{{ request('search') ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4 pb-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="order_date" class="form-control datepicker"
                                                    value="{{ request('order_date') ?? '' }}" placeholder="Order Date"
                                                    autocomplete="off" autofocus readonly>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-calendar"></i> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mt-0">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap text-center">
                            <thead>
                                <tr>
                                    <th>Sl.no</th>
                                    <th>Order Date</th>
                                    <th>Order No</th>
                                    <th>Invoice</th>
                                    <th>Short Info</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ dateFormat($order->created_at, 'd M, y') }}</td>
                                        <td>{{ $order->order_number ?? '' }}</td>
                                        <td>{{ $order->invoice ?? '' }}</td>
                                        <td class="text-center">
                                            <a type="button" class="btn btn-sm btn-info show-order-products"
                                                data-id="{{ $order->unique_id }}">
                                                <i class="fa fa-eye fa-xl"></i>
                                            </a>
                                        </td>
                                        <td>{{ numberFormat($order->total_order_price, 2) }}</td>
                                        <td>

                                        </td>
                                    </tr>
                                @empty
                                    <x-no-data-found></x-no-data-found>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {!! $orders->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="show-order-products" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title product-modal-header" id="exampleModalLabel">Product Variants</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Sub subcategory</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td id="category_name"></td>
                                <td id="subcategory_name"></td>
                                <td id="sub_subcategory_name"></td>
                            </tbody>
                        </table>
                        <hr>
                        <h3>Variants</h3>

                        <table class="table table-bordered table-striped table-md">
                            <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Unit Price</th>
                                    <th>Discount Price</th>
                                    <th>Inventory</th>
                                </tr>
                            </thead>
                            <tbody id="product-variants-container">
                                <!-- Rows will be dynamically appended here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/manage_orders.js') }}"></script>
@endpush
