@extends('admin.layouts.app')
@section('title', 'Product List')
@push('css')

@endpush

@section('content')

    <div class="row">
        <div class="col-12">
            @if (!authShopInfo())
                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="mdi mdi-alert-circle-outline me-2"></i>
                    <span class="flex-grow-1">
                        You can't add/edit any product without setting your shop.
                        <a href="{{ route('admin.shop-info') }}"
                           class="alert-link text-decoration-underline">click here</a>
                        to set your shop.
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Product List</h4>

                <div class="page-title-right">
                    @if (authShopInfo())
                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus-circle"></i> Add New
                        </a>
                    @endif
                </div>

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
                                aria-expanded="{{ request()->query() ? 'true' : 'false' }}"
                                aria-controls="collapseSearch">
                            Search
                        </button>
                    </h2>
                    <div id="collapseSearch" class="accordion-collapse collapse {{ request()->query() ? 'show' : '' }}"
                         aria-labelledby="headingSearch" data-bs-parent="#accordionSearch">
                        <div class="accordion-body">
                            <form method="GET" action="{{ route('admin.products.index') }}">
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
                                                            {{ request('seller') === $seller->code ? 'selected' : '' }}>
                                                            {{ $seller->name }} ({{ $seller->shop->shop_name ?? '' }})
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
                                            <select name="status" class="form-select">
                                                <option value="" {{ !isset(request()->status) ? 'selected' : '' }}>
                                                    Status
                                                </option>
                                                @foreach (getStatus() as $status)
                                                    <option value="{{ $status->value }}"
                                                        {{ request('status') === $status->value ? 'selected' : '' }}>
                                                        {{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="number" name="stock_less_than" class="form-control"
                                                   placeholder="Stock Less Than" value="{{ request('stock_less_than') ?? '' }}">
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
                                <th class="text-center">Thumbnail</th>
                                <th>Name</th>
                                <th class="text-center">Variant</th>
                                <th class="text-center">Inventory</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td>{{ $product->type->name ?? '' }}</td>
                                    <td class="text-center padding-5">
                                        @if ($product->thumbnail_path != null && file_exists($product->thumbnail_path))
                                            <img src="{{ asset($product->thumbnail_path) }}"
                                                 class="avatar-sm rounded-3">
                                        @else
                                            <img src="{{ asset('assets/common/images/ecommerce.png') }}"
                                                 class="avatar-sm rounded-3">
                                        @endif
                                    </td>
                                    <td>{{ $product->name ?? '' }}</td>
                                    <td class="text-center">
                                        <a type="button" class="btn btn-sm btn-info view-product-variants"
                                           data-bs-toggle="modal" data-bs-target="#show-product-variants"
                                           data-id="{{ $product->id }}">
                                            <i class="fa fa-eye fa-xl"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a type="button"
                                           data-bs-placement="top"
                                           title="Update Inventory"
                                           class="btn btn-sm btn-primary view-product-variants"
                                           data-bs-toggle="modal" data-bs-target="#show-product-variants"
                                           data-id="{{ $product->id }}">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" id="product-{{ $loop->index + 1 }}"
                                               class="product-status" data-id="{{ $product->id }}" switch="bool"
                                            {{ isActive($product->status) ? 'checked' : '' }} />
                                        <label class="custom-label-margin" for="product-{{ $loop->index + 1 }}" data-on-label="Yes"
                                               data-off-label="No"></label>
                                    </td>
                                    <td class="text-center">
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Show Details"
                                           href="{{ route('admin.products.show', $product->slug) }}"
                                           class="btn btn-sm btn-soft-info"><i class="fa fa-eye"></i>
                                        </a>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.products.edit', $product->slug) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i>
                                        </a>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                           class="btn btn-sm btn-soft-danger delete-data"
                                           data-id="{{ 'delete-product-' . $product->id }}"
                                           href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-product-{{ $product->id }}"
                                              action="{{ route('admin.products.destroy', $product->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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

    <div class="modal fade" id="show-product-variants" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
                                <th>Brand</th>
                            </tr>
                            </thead>
                            <tbody>
                            <td id="category_name"></td>
                            <td id="subcategory_name"></td>
                            <td id="sub_subcategory_name"></td>
                            <td id="brand_name"></td>
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
    <script src="{{ asset('assets/admin/js/custom/product_lists.js') }}"></script>
@endpush
