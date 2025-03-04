@extends('admin.layouts.app')
@section('title', 'Product Add/Edit')
@push('css')
    <style>
        table {
            table-layout: fixed;
            /* Ensures consistent column width */
        }

        td,
        th {
            word-wrap: break-word;
            white-space: nowrap;
        }

        select.form-control {
            width: 100%;
            /* Forces full width for dropdown */
        }

        .th-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .inherit-box {
            white-space: inherit !important;
        }
        .variant-error-message {
            display: block; /* Ensure the message stays within its column */
            white-space: normal; /* Wrap text if it's too long */
            max-width: 100%; /* Prevent overflow from the table cell */
            overflow-wrap: break-word; /* Break long words */
            font-size: 0.875rem; /* Optional: Adjust the font size */
            padding-top: 5px; /* Add spacing between the input and the error message */
        }


        /* Breaks long words if necessary */

    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Product Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-arrow-circle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ $route }}" method="POST" id="product-form" enctype="multipart/form-data">
                        <input type="hidden" id="method_mode" value="{{ isset($product) ? 'PUT' : 'POST' }}">
                        @csrf
                        @isset($product)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Product Code (SKU) {!! starSign() !!}</label>
                                    <input type="text" name="product_code" value="{{ $product->product_code ?? '' }}"
                                           class="form-control product_product_code product-input-control"
                                           placeholder="Product Code">
                                    <span id="product_product_code_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name {!! starSign() !!}</label>
                                    <input type="text" name="name" value="{{ $product->name ?? '' }}"
                                           class="form-control product_name product-input-control" placeholder="Name">
                                    <span id="product_name_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Product Type {!! starSign() !!}</label>
                                    <select name="product_type" id="product_type"
                                            class="form-control select2 product_product_type product-input-control">
                                        <option value="">Select Product Type</option>
                                        @foreach (activeProductTypes() as $type)
                                            <option value="{{ $type->id }}"
                                                {{ isset($product) && $product->product_type_id == $type->id ? 'selected' : '' }}>
                                                {{ $type->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span id="product_product_type_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Category {!! starSign() !!}</label>
                                    <select name="category" id="category"
                                            class="form-control select2 product_category product-input-control">
                                        <option value="">Select Category</option>
                                        @foreach (activeCategories() as $category)
                                            <option value="{{ $category->id }}"
                                                {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span id="product_category_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Sub Category</label>
                                    <select name="subcategory" id="subcategory"
                                            class="form-control select2 product_subcategory product-input-control"
                                            data-old-value="{{ $product->subcategory_id ?? '' }}">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                    <span id="product_subcategory_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Sub Subcategory</label>
                                    <select name="sub_subcategory" id="sub_subcategory"
                                            class="form-control select2 product_sub_subcategory product-input-control"
                                            data-old-value="{{ $product->sub_subcategory_id ?? '' }}">
                                        <option value="">Select Sub Subcategory</option>
                                    </select>
                                    <span id="product_sub_subcategory_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Brand</span>
                                        <a type="button" class="text-primary" data-bs-toggle="modal"
                                           data-bs-target="#brand-add-modal">
                                            <i class="fa fa-plus-circle fa-xl"></i>
                                        </a>
                                    </label>
                                    <select name="brand" id="brand"
                                            class="form-control select2 product_brand product-input-control">
                                        <option value="">Select Brand</option>
                                        @foreach (activeBrands() as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ isset($product) && $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span id="product_brand_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Tags</span>
                                        <a type="button" class="text-primary" data-bs-toggle="modal"
                                           data-bs-target="#tag-add-modal">
                                            <i class="fa fa-plus-circle fa-xl"></i>
                                        </a>
                                    </label>
                                    <select name="tags[]" id="tag"
                                            class="form-control select2 product_tags product-input-control"
                                            multiple="multiple" data-placeholder="Tags ...">
                                        <option value="">Select Tags</option>
                                        @foreach (allTags() as $tag)
                                            <option value="{{ $tag->name }}"
                                                {{ isset($product) && in_array($tag->name, productTagsToArray($product->id)) ? 'selected' : '' }}>
                                                {{ $tag->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span id="product_tags_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description"
                                              class="form-control product_short_description product-input-control"
                                              placeholder="Short Description">{{ $product->short_description ?? '' }}</textarea>
                                    <span id="product_short_description_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Special Note</label>
                                    <textarea name="special_note"
                                              class="form-control product_special_note product-input-control"
                                              placeholder="Special Note">{{ $product->special_note ?? '' }}</textarea>
                                    <span id="product_special_note_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Product Details {!! starSign() !!}</label>
                                    <textarea name="product_details"
                                              class="form-control product_product_details product-input-control"
                                              id="product_details">{{ $product->product_details ?? '' }}</textarea>
                                    <span id="product_product_details_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Product Specification</label>
                                    <textarea name="product_specification"
                                              class="form-control product_product_specification product-input-control"
                                              id="product_specification">{{ $product->product_specification ?? '' }}</textarea>
                                    <span id="product_product_specification_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Product Compare</label>
                                    <textarea name="product_compare"
                                              class="form-control product_product_compare product-input-control"
                                              id="product_compare">{{ $product->product_compare ?? '' }}</textarea>
                                    <span id="product_product_compare_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Price Variants</div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-responsive"
                                                   id="product-variant-table">
                                                <thead>
                                                <tr class="form-label">
                                                    <th class="w-10">Default</th>
                                                    <th>
                                                        <div class="th-content">
                                                            <span>Size</span>
                                                            <a type="button" class="text-primary"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#size-add-modal">
                                                                <i class="fa fa-plus-circle fa-xl"></i>
                                                            </a>
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="th-content">
                                                            <span>Color</span>
                                                            <a type="button" class="text-primary"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#color-add-modal">
                                                                <i class="fa fa-plus-circle fa-xl"></i>
                                                            </a>
                                                        </div>
                                                    </th>
                                                    <th>Unit Price {!! starSign() !!}</th>
                                                    <th>Discount Price {!! starSign() !!}</th>
                                                    <th>Inventory {!! starSign() !!}</th>
                                                    <th class="w-10">Action</th>
                                                </tr>


                                                </thead>
                                                <tbody>
                                                @if (isset($product) && $product->total_variant > 0)
                                                    <input type="hidden" id="total_variant"
                                                           value="{{ $product->total_variant }}">
                                                    @foreach ($product->variants as $key => $variant)
                                                        <tr data-index="{{ $key }}">
                                                            <td>
                                                                {{-- Hidden Inputs--}}
                                                                <input type="hidden" name="variants[{{ $key }}][is_new]"
                                                                       value="0">
                                                                <input type="hidden"
                                                                       name="variants[{{ $key }}][variant_id]"
                                                                       value="{{ $variant->id }}">
                                                                <input type="hidden"
                                                                       name="variants[{{ $key }}][index_no]"
                                                                       value="{{ $key }}">

                                                                <input type="radio"
                                                                       name="variants[{{ $key }}][is_default]"
                                                                       id="variant_is_default_{{ $key }}"
                                                                       value="{{ $variant->is_default }}"
                                                                       class="variant-is-default" {{ $variant->is_default == 1 ? 'checked' : '' }}>
                                                                <label
                                                                    for="variant_is_default_{{ $key }}"></label>
                                                            </td>
                                                            <td>
                                                                <select name="variants[{{ $key }}][size]"
                                                                        id="variant_size_{{ $key }}"
                                                                        class="form-select product_sizes">
                                                                    <option value="">Select Size</option>
                                                                    @foreach (allSizes() as $size)
                                                                        <option value="{{ $size->id }}"
                                                                            {{ isset($product) && $size->id == $variant->size_id ? 'selected' : '' }}>
                                                                            {{ $size->name ?? '' }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="text-danger variant-error-message"
                                                                       id="variant_size_{{ $key }}_error"></small>
                                                            </td>
                                                            <td>
                                                                <select name="variants[{{ $key }}][color]"
                                                                        id="variant_color_{{ $key }}"
                                                                        class="form-control select2 product_colors">
                                                                    <option value="">Select Color</option>
                                                                    @foreach (allColors() as $color)
                                                                        <option value="{{ $color->id }}"
                                                                            {{ isset($product) && $color->id == $variant->color_id ? 'selected' : '' }}>
                                                                            {{ $color->name ?? '' }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="text-danger variant-error-message"
                                                                       id="variant_color_{{ $key }}_error"></small>
                                                            </td>
                                                            <td class="inherit-box">
                                                                <input type="number"
                                                                       value="{{ $variant->unit_price ?? 0 }}"
                                                                       name="variants[{{ $key }}][unit_price]"
                                                                       id="variant_unit_price_{{ $key }}"
                                                                       class="form-control product_unit_price"
                                                                       placeholder="Unit Price">
                                                                <small class="text-danger variant-error-message"
                                                                       id="variant_unit_price_{{ $key }}_error"></small>
                                                            </td>
                                                            <td class="inherit-box">
                                                                <input type="number"
                                                                       value="{{ $variant->discount_price ?? 0 }}"
                                                                       name="variants[{{ $key }}][discount_price]"
                                                                       id="variant_discount_price_{{ $key }}"
                                                                       class="form-control product_discount_price"
                                                                       placeholder="Discount Price">
                                                                <small class="text-danger variant-error-message"
                                                                       id="variant_discount_price_{{ $key }}_error"></small>
                                                            </td>
                                                            <td class="inherit-box">
                                                                <input type="number"
                                                                       value="{{ $variant->inventory ?? 0 }}"
                                                                       name="variants[{{ $key }}][inventory]"
                                                                       id="variant_inventory_{{ $key }}"
                                                                       class="form-control product_inventory"
                                                                       placeholder="Discount Price">
                                                                <small class="text-danger variant-error-message"
                                                                       id="variant_inventory_{{ $key }}_error"></small>
                                                            </td>
                                                            <td class="w-10 pull-right">
                                                                <button type="button"
                                                                        class="btn btn-md btn-danger text-right remove_variant">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>

                                            <button type="button" class="btn btn-sm btn-success" id="add-variant">Add
                                                More
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label d-flex align-items-center justify-content-between">
                                            <span>Unit</span>
                                            <a type="button" class="text-primary" data-bs-toggle="modal"
                                               data-bs-target="#unit-add-modal">
                                                <i class="fa fa-plus-circle fa-xl"></i>
                                            </a>
                                        </label>
                                        <select name="unit" id="unit"
                                                class="form-control select2 product_unit product-input-control">
                                            <option value="">Select Unit</option>
                                            @foreach (allUnits() as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ isset($product) && $product->product_unit == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                        <span id="product_unit_error"
                                              class="text-danger font-weight-500 product-error-message"></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Refundable {!! starSign() !!}</label>
                                        <select name="is_refundable"
                                                class="form-select product_is_refundable product-input-control">
                                            <option value="0"
                                                {{ isset($product) && $product->is_refundable == 0 ? 'selected' : '' }}>
                                                No
                                            </option>
                                            <option value="1"
                                                {{ isset($product) && $product->is_refundable == 1 ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                        <span id="product_is_refundable_error"
                                              class="text-danger font-weight-500 product-error-message"></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Exchangeable {!! starSign() !!}</label>
                                        <select name="is_exchangeable"
                                                class="form-select product_is_exchangeable product-input-control">
                                            <option value="0"
                                                {{ isset($product) && $product->is_exchangeable == 0 ? 'selected' : '' }}>
                                                No
                                            </option>
                                            <option value="1"
                                                {{ isset($product) && $product->is_exchangeable == 1 ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                        <span id="product_is_exchangeable_error"
                                              class="text-danger font-weight-500 product-error-message"></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Warranty</label>
                                        <input type="text" name="warranty" value="{{ $product->warranty ?? '' }}"
                                               class="form-control product_warranty product-input-control"
                                               placeholder="Warranty">
                                        <span id="product_warranty_error"
                                              class="text-danger font-weight-500 product-error-message"></span>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Video Link</label>
                                        <input type="text" name="video_link" value="{{ $product->video_link ?? '' }}"
                                               class="form-control product_video_link product-input-control"
                                               placeholder="Video Link">
                                        <span id="product_video_link_error"
                                              class="text-danger font-weight-500 product-error-message"></span>
                                    </div>
{{--                                    <div class="col-md-6 mb-3">--}}
{{--                                        <label class="form-label">Listed On {!! starSign() !!}</label>--}}
{{--                                        <select name="listed_on"--}}
{{--                                                class="form-select product_status product-input-control">--}}
{{--                                            @foreach (listedOn() as $listed_on)--}}
{{--                                                <option value="{{ $listed_on->value }}"--}}
{{--                                                    {{ isset($product) && $product->listed_on === $listed_on->value ? 'selected' : '' }}>--}}
{{--                                                    {{ $listed_on->title }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        <span id="product_status_error"--}}
{{--                                              class="text-danger font-weight-500 product-error-message"></span>--}}
{{--                                    </div>--}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status {!! starSign() !!}</label>
                                        <select name="status" class="form-select product_status product-input-control">
                                            @foreach (getStatus() as $status)
                                                <option value="{{ $status->value }}"
                                                    {{ isset($product) && $product->status === $status->value ? 'selected' : '' }}>
                                                    {{ $status->title }}</option>
                                            @endforeach
                                        </select>
                                        <span id="product_status_error"
                                              class="text-danger font-weight-500 product-error-message"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Thumbnail (Type:jpg,jpeg,png, Max:
                                        1MB, Rc: 375x480) {!! starSign() !!}</span>
                                        @if(isset($product->thumbnail_path) && file_exists($product->thumbnail_path))
                                            <button type="button"
                                                    class="custom-badge badge-info view-image"
                                                    data-image-url="{{ asset($product->thumbnail_path) }}"
                                                    title="View Image">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <input type="file" name="product_thumbnail"
                                           class="form-control product_product_thumbnail product-input-control"
                                           accept=".jpg,.jpeg,.png">
                                    <span id="product_product_thumbnail_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>

                                <div class="mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Product Images
                                                <small><strong class="badge badge-pill badge-info">(Type:jpg,jpeg,png,
                                                        Max:1MB, Rc: 375x480)</strong></small>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <b id="product_images_error"
                                               class="text-danger font-weight-500 product-error-message"></b>
                                            <table class="table table-responsive table-stripped w-100"
                                                   id="product_image_table">
                                                <thead>
                                                <tr class="form-label">
                                                    <th>Image{!! starSign() !!}</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if (isset($product) && count($product->images))
                                                    <input type="hidden" id="total_images"
                                                           value="{{ $product->total_images }}">
                                                    @foreach ($product->images as $key => $image)
                                                        <tr data-index="{{ $key }}">
                                                            <td class="w-85">
                                                                {{--Hidden inputs--}}
                                                                <input type="hidden" name="images[{{ $key }}][is_new]"
                                                                       value="0">
                                                                <input type="hidden" name="images[{{ $key }}][index_no]"
                                                                       value="{{ $key }}">
                                                                <input type="hidden" name="images[{{ $key }}][image_id]"
                                                                       value="{{ $image->id }}">
                                                                {{--file input--}}
                                                                <input type="file" name="images[{{ $key }}][image]"
                                                                       id="product_image_{{ $key }}"
                                                                       class="form-control" accept=".jpg,.jpeg,.png">
                                                                <small
                                                                    class="text-danger font-weight-500 product-image-error-message"
                                                                    id="product_image_{{ $key }}_error"></small>
                                                            </td>
                                                            <td class="w-15 float-end">
                                                                <!-- View Image Link -->
                                                                @if ($image->image_path && file_exists($image->image_path))
                                                                    <button type="button"
                                                                            class="btn btn-md btn-info view-image"
                                                                            data-image-url="{{ asset($image->image_path) }}"
                                                                            title="View Image">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                            @endif
                                                            <!-- Remove Image Button -->
                                                                <button type="button"
                                                                        class="btn btn-md btn-danger remove_image"
                                                                        title="Remove Image">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>

                                            <button type="button" class="btn btn-sm btn-success" id="add_image">Add
                                                Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary submit-button" id="product-submit" type="button">Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="brand-add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="brand-add-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="col-form-label">Name {!! starSign() !!}</label>
                            <input type="text" name="name" placeholder="Name"
                                   class="form-control brand-form-control brand-name-input">
                            <span id="brand_name_error" class="text-danger font-weight-500 brand-error-message"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Logo (Type:jpg,jpeg,png, Max: 1MB)</label>
                            <input type="file" name="logo" class="form-control brand-form-control brand-logo-input"
                                   accept=".jpg,jpeg,.png">
                            <span id="brand_logo_error" class="text-danger font-weight-500 brand-error-message"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Status {!! starSign() !!}</label>
                            <select name="status" class="form-select brand-form-control brand-status-input">
                                @foreach (getStatus() as $status)
                                    <option value="{{ $status->value }}">{{ $status->title }}</option>
                                @endforeach
                            </select>
                            <span id="brand_status_error"
                                  class="text-danger font-weight-500 brand-error-message"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary brand-add-button">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="unit-add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="unit-add-form" method="POST">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="col-form-label">Name {!! starSign() !!}</label>
                            <input type="text" name="name" placeholder="Name"
                                   class="form-control unit-form-input">
                            <span id="unit_name_error" class="text-danger font-weight-500"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary unit-add-button">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="size-add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="size-add-form" method="POST">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="col-form-label">Name {!! starSign() !!}</label>
                            <input type="text" name="name" placeholder="Name"
                                   class="form-control size-form-input">
                            <span id="size_name_error" class="text-danger font-weight-500"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary size-add-button">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="color-add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="color-add-form" method="POST">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="col-form-label">Name {!! starSign() !!}</label>
                            <input type="text" name="name" placeholder="Name"
                                   class="form-control color-form-input">
                            <span id="color_name_error" class="text-danger font-weight-500"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary color-add-button">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tag-add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tag-add-form" method="POST">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="col-form-label">Name {!! starSign() !!}</label>
                            <input type="text" name="name" placeholder="Name" class="form-control tag-form-input">
                            <span id="tag_name_error" class="text-danger font-weight-500"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary tag-add-button">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/product_add_edit.js') }}"></script>
@endpush
