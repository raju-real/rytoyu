@extends('admin.layouts.app')
@section('title', 'Product List')
@push('css')
    <style>
        .table td {
            text-align: left;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Accordion for Search -->
            <div class="accordion mb-3" id="accordionSearch">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSearch">
                        <button class="accordion-button {{ request()->query() ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseSearch"
                                aria-expanded="{{ request()->query() ? 'true' : 'false' }}"
                                aria-controls="collapseSearch">
                            Search
                        </button>
                    </h2>
                    <div id="collapseSearch" class="accordion-collapse collapse {{ request()->query() ? 'show' : '' }}"
                         aria-labelledby="headingSearch" data-bs-parent="#accordionSearch">
                        <div class="accordion-body">
                            <form method="GET" action="{{ route('admin.seller-products') }}">
                                <div class="row">
                                    @if (authAdminType() === 'administrator')
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <select name="seller" class="form-select" id="seller">
                                                    <option value=""
                                                        {{ !isset(request()->seller) ? 'selected' : '' }}>
                                                        Seller
                                                    </option>
                                                    @foreach (allSellers() as $seller)
                                                        <option value="{{ $seller->code }}"
                                                            {{ request('seller') == $seller->code ? 'selected' : '' }}>
                                                            {{ $seller->code. ' - '.$seller->name }} ({{ $seller->shop->shop_name ?? '' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <select name="brand" class="form-select" id="brand">
                                                <option value="" {{ !isset(request()->brand) ? 'selected' : '' }}>
                                                    Brand
                                                </option>
                                                @foreach (allBrands() as $brand)
                                                    <option value="{{ $brand->slug }}"
                                                        {{ request('brand') === $brand->slug ? 'selected' : '' }}>
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <select name="category" class="form-select" id="category">
                                                <option value="" {{ !isset(request()->category) ? 'selected' : '' }}>
                                                    Category
                                                </option>
                                                @foreach (activeCategories() as $category)
                                                    <option value="{{ $category->slug }}"
                                                        {{ request('category') === $category->slug ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="from-group mb-3">
                                            <select name="subcategory" id="subcategory" class="form-select"
                                                    data-old-value="{{ subCategoryIdBySlug(request('subcategory')) }}">
                                                <option value="">Sub Category</option>
                                                @if (!empty(request('subcategory')))
                                                    <option value="{{ request('subcategory') }}" selected>
                                                        {{ subcategoryNameBySlug(request('subcategory')) }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="from-group mb-3">
                                            <select name="sub_subcategory" id="sub_subcategory" class="form-select"
                                                    data-old-value="{{ subSubCategoryIdBySlug(request('sub_subcategory')) }}">
                                                <option value="">Sub Category</option>
                                                @if (!empty(request('sub_subcategory')))
                                                    <option value="{{ request('sub_subcategory') }}" selected>
                                                        {{ subSubCategoryNameBySlug(request('sub_subcategory')) }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="search" name="name" class="form-control"
                                                   placeholder="Search by Name" value="{{ request('name') ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <select name="request_status" class="form-select">
                                                <option value="" {{ !isset(request()->request_status) ? 'selected' : '' }}>
                                                    Status
                                                </option>
                                                @foreach (getRequestStatus() as $status)
                                                    <option value="{{ $status->value }}"
                                                        {{ request('request_status') === $status->value ? 'selected' : '' }}>
                                                        {{ $status->title }}</option>
                                                @endforeach
                                            </select>
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
                        <table class="table table-striped table-bordered mb-0 text-start">
                            <thead class="table-light">
                            <tr>
                                <th class="text-center">Sl.no</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Thumbnail</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td>{{ $product->type->name ?? '' }}</td>
                                    <td>{{ $product->category->name ?? '' }}</td>
                                    <td>{{ $product->brand->name ?? '' }}</td>
                                    <td>
                                        @if ($product->thumbnail_path != null && file_exists($product->thumbnail_path))
                                            <img src="{{ asset($product->thumbnail_path) }}"
                                                 class="avatar-sm rounded-3 d-block ">
                                        @else
                                            <img src="{{ asset('assets/common/images/ecommerce.png') }}"
                                                 class="avatar-sm rounded-3 d-block">
                                        @endif
                                    </td>
                                    <td {!! tooltip($product->name ?? '') !!}>{{ textLimit($product->name ?? '') }}</td>
                                    <td>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Show Details"
                                           href="{{ route('admin.seller-product', $product->slug) }}"
                                           class="btn btn-sm btn-soft-info"><i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <x-no-data-found></x-no-data-found>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-lg-12">
                    <ul class="pagination pagination-rounded justify-content-center mt-3 mb-4 pb-1">
                        {{ $products->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/seller_products.js') }}"></script>
@endpush

