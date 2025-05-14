@extends('admin.layouts.app')
@section('title','Latest Offer Product')
@push('css')
    <link href="{{ asset('assets/admin/css/product_add.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Latest Offer Product</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
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
    <script src="{{ asset('assets/admin/js/custom/latest_offer.js') }}"></script>
@endpush
