@extends('admin.layouts.app')
@section('title','New in Product')
@push('css')
    <link href="{{ asset('assets/admin/css/product_add.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">New in Product</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <p class="alert alert-info">If you don't set any product on this section and make as active by
                default randomly 15 newly added products will display on web page for this section.</p>
            <x-sort-available/>
            <div class="form-group mb-3">
                <div class="position-relative">
                    <input type="search" id="product-search" class="form-control"
                           placeholder="Search product by SKU or Product Name">
                    <div id="product-search-results" class="list-group"></div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap" id="new-in-products-table">
                            <thead>
                            <tr>
                                <th>Sorting Serial</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="sort_new-in"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/new_in_products.js') }}"></script>
@endpush
