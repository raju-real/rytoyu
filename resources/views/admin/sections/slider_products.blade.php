@extends('admin.layouts.app')
@section('title','Products on '.$slider->title)
@push('css')
    <link href="{{ asset('assets/admin/css/product_add.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Products on {{ $slider->title }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <x-sort-available/>
            <div class="form-group mb-3">
                <div class="position-relative">
                    <input type="hidden" id="slider_id" value="{{ $slider->id }}">
                    <input type="search" id="product-search" class="form-control"
                           placeholder="Search product by SKU or Product Name">
                    <div id="product-search-results" class="list-group"></div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap" id="slider-products-table">
                            <thead>
                            <tr>
                            <tr>
                                <th>Sorting Serial</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Seller</th>
                                <th>SKU</th>
                                <th>Actions</th>
                            </tr>
                            </tr>
                            </thead>
                            <tbody class="sort_slider">

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/slider_products.js') }}"></script>
@endpush
