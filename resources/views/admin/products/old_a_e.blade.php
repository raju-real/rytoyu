@extends('admin.layouts.app')
@section('title','Product Add/Edit')
@push('css') @endpush

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
                        @csrf
                        @isset($product)
                            @method('PUT')
                        @endisset
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Product Code {!! starSign() !!}</label>
                                    <input type="text" name="product_code"
                                           value="{{ $product->product_code ?? '' }}"
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
                                           class="form-control product_name product-input-control"
                                           placeholder="Name">
                                    <span id="product_name_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Category {!! starSign() !!}</label>
                                    <select name="category" id="category"
                                            class="form-control select2 product_category product-input-control">
                                        <option value="">Select Category</option>
                                        @foreach(activeCategories() as $category)
                                            <option
                                                value="{{ $category->id }}" {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span id="product_category_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
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
                                            data-old-value="{{ $product->sub_subcategory_id ?? ''  }}">
                                        <option value="">Select Sub Subcategory</option>
                                    </select>
                                    <span id="product_sub_subcategory_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
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
                                        @foreach(activeBrands() as $brand)
                                            <option
                                                value="{{ $brand->id }}" {{ isset($product) && $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span id="product_brand_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
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
                                        @foreach(allUnits() as $unit)
                                            <option
                                                value="{{ $unit->id }}" {{ isset($product) && $product->product_unit == $unit->id ? 'selected' : '' }}>{{ $unit->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span id="product_unit_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Sizes</span>
                                        <a type="button" class="text-primary" data-bs-toggle="modal"
                                           data-bs-target="#size-add-modal">
                                            <i class="fa fa-plus-circle fa-xl"></i>
                                        </a>
                                    </label>
                                    <select name="sizes[]" id="size"
                                            class="form-control product_sizes select2 product-input-control"
                                            multiple="multiple"
                                            data-placeholder="Sizes ...">
                                        <option value="">Select Sizes</option>
                                        @foreach(allSizes() as $size)
                                            <option
                                                value="{{ $size->name }}" {{ isset($product) && in_array($size->name,productSizesToArray($product->id)) ? 'selected' : '' }}>{{ $size->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span id="product_sizes_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Colors</span>
                                        <a type="button" class="text-primary" data-bs-toggle="modal"
                                           data-bs-target="#color-add-modal">
                                            <i class="fa fa-plus-circle fa-xl"></i>
                                        </a>
                                    </label>
                                    <select name="colors[]" id="color"
                                            class="form-control select2 product_colors product-input-control"
                                            multiple="multiple"
                                            data-placeholder="Colors ...">
                                        <option value="">Select Colors</option>
                                        @foreach(allColors() as $color)
                                            <option
                                                value="{{ $color->name }}" {{ isset($product) && in_array($color->name,productColorsToArray($product->id)) ? 'selected' : '' }}>{{ $color->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span id="product_colors_error"
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
                                            multiple="multiple"
                                            data-placeholder="Tags ...">
                                        <option value="">Select Tags</option>
                                        @foreach(allTags() as $tag)
                                            <option
                                                value="{{ $tag->name }}" {{ isset($product) && in_array($tag->name,productTagsToArray($product->id)) ? 'selected' : '' }}>{{ $tag->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span id="product_tags_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Unit Price {!! starSign() !!}</label>
                                    <input type="number" name="unit_price" value="{{ $product->unit_price ?? '' }}"
                                           class="form-control product_unit_price product-input-control"
                                           placeholder="Unit Price">
                                    <span id="product_unit_price_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Discount Price</label>
                                    <input type="number" name="discount_price"
                                           value="{{ $product->discount_price ?? 0 }}"
                                           class="form-control product_discount_price product-input-control"
                                           placeholder="Discount Price">
                                    <span id="product_discount_price_error"
                                          class="text-danger font-weight-500 product-error-message"></span>
                                </div>
                            </div>

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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">SKU {!! starSign() !!}</label>
                                            <input type="number" name="sku" value="{{ $product->sku ?? 0 }}"
                                                   class="form-control product_sku product-input-control"
                                                   placeholder="SKU">
                                            <span id="product_sku_error"
                                                  class="text-danger font-weight-500 product-error-message"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Alert Quantity {!! starSign() !!}</label>
                                            <input type="number" name="alert_quantity"
                                                   value="{{ $product->alert_quantity ?? 0 }}"
                                                   class="form-control product_alert_quantity product-input-control"
                                                   placeholder="Alert Quantity">
                                            <span id="product_alert_quantity_error"
                                                  class="text-danger font-weight-500 product-error-message"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Refundable {!! starSign() !!}</label>
                                            <select name="is_refundable"
                                                    class="form-select select2-search-disable product_is_refundable product-input-control">
                                                <option
                                                    value="0" {{ isset($product) && $product->is_refundable == 0 ? 'selected' : '' }}>
                                                    No
                                                </option>
                                                <option
                                                    value="1" {{ isset($product) && $product->is_refundable == 1 ? 'selected' : '' }}>
                                                    Yes
                                                </option>
                                            </select>
                                            <span id="product_is_refundable_error"
                                                  class="text-danger font-weight-500 product-error-message"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Exchangeable {!! starSign() !!}</label>
                                            <select name="is_exchangeable"
                                                    class="form-select select2-search-disable product_is_exchangeable product-input-control">
                                                <option
                                                    value="0" {{ isset($product) && $product->is_exchangeable == 0 ? 'selected' : '' }}>
                                                    No
                                                </option>
                                                <option
                                                    value="1" {{ isset($product) && $product->is_exchangeable == 1 ? 'selected' : '' }}>
                                                    Yes
                                                </option>
                                            </select>
                                            <span id="product_is_exchangeable_error"
                                                  class="text-danger font-weight-500 product-error-message"></span>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Video Link</label>
                                            <input type="text" name="video_link"
                                                   value="{{ $product->video_link ?? '' }}"
                                                   class="form-control product_video_link product-input-control"
                                                   placeholder="Video Link">
                                            <span id="product_video_link_error"
                                                  class="text-danger font-weight-500 product-error-message"></span>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Warranty</label>
                                            <input type="text" name="warranty"
                                                   value="{{ $product->warranty ?? '' }}"
                                                   class="form-control product_warranty product-input-control"
                                                   placeholder="Warranty">
                                            <span id="product_warranty_error"
                                                  class="text-danger font-weight-500 product-error-message"></span>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Listed On {!! starSign() !!}</label>
                                            <select name="listed_on"
                                                    class="form-select select2-search-disable product_status product-input-control">
                                                @foreach(listedOn() as $listed_on)
                                                    <option
                                                        value="{{ $listed_on->value }}" {{ isset($product) && $product->listed_on === $listed_on->value ? 'selected' : '' }}>{{ $listed_on->title }}</option>
                                                @endforeach
                                            </select>
                                            <span id="product_status_error"
                                                  class="text-danger font-weight-500 product-error-message"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status {!! starSign() !!}</label>
                                            <select name="status"
                                                    class="form-select select2-search-disable product_status product-input-control">
                                                @foreach(getStatus() as $status)
                                                    <option
                                                        value="{{ $status->value }}" {{ isset($product) && $product->status === $status->value ? 'selected' : '' }}>{{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                            <span id="product_status_error"
                                                  class="text-danger font-weight-500 product-error-message"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Thumbnail (Type:jpg,jpeg,png, Max:
                                            1MB, Rc: 312x272) {!! starSign() !!}</label>
                                        <input type="file" name="product_thumbnail"
                                               class="form-control product_product_thumbnail product-input-control"
                                               accept=".jpg,.jpeg,.png">
                                        <span id="product_product_thumbnail_error"
                                              class="text-danger font-weight-500 product-error-message"></span>
                                    </div>

                                    <div class="mb-3">
                                        <b id="product_images_error"
                                           class="text-danger font-weight-500 product-error-message"></b>
                                        <table class="table w-100" id="image_table">
                                            <thead>
                                            <tr class="form-label">
                                                <th>Product Images(Type:jpg,jpeg,png,Max:1MB,Rc:
                                                    312x272) {!! starSign() !!}</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($product) && count($product->images))
                                                @foreach($product->images as $image)
                                                    <tr>
                                                        <td class="w-70">
                                                            <input type="file" name="images[]" class="form-control"
                                                                   accept=".jpg,.jpeg,.png">
                                                        </td>
                                                        <td class="w-20 text-center">
                                                            <!-- View Image Link -->
                                                            @if($image->image_path && file_exists($image->image_path))
                                                                <button type="button"
                                                                        class="btn btn-md btn-info view-image"
                                                                        data-image-url="{{ asset($image->image_path) }}"
                                                                        title="View Image">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                        <td class="w-10 pull-right">
                                                            <button type="button"
                                                                    class="btn btn-md btn-danger text-right remove_image">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>

                                        <button type="button" class="btn btn-sm btn-success" id="add_image">Add Image
                                        </button>
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
                            <span id="brand_name_error"
                                  class="text-danger font-weight-500 brand-error-message"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Logo (Type:jpg,jpeg,png, Max: 1MB)</label>
                            <input type="file" name="logo" class="form-control brand-form-control brand-logo-input"
                                   accept=".jpg,jpeg,.png">
                            <span id="brand_logo_error"
                                  class="text-danger font-weight-500 brand-error-message"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Status {!! starSign() !!}</label>
                            <select name="status" class="form-select brand-form-control brand-status-input">
                                @foreach(getStatus() as $status)
                                    <option
                                        value="{{ $status->value }}">{{ $status->title }}</option>
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
                            <input type="text" name="name" placeholder="Name" class="form-control unit-form-input">
                            <span id="unit_name_error"
                                  class="text-danger font-weight-500"></span>
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
                            <input type="text" name="name" placeholder="Name" class="form-control size-form-input">
                            <span id="size_name_error"
                                  class="text-danger font-weight-500"></span>
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
                            <input type="text" name="name" placeholder="Name" class="form-control color-form-input">
                            <span id="color_name_error"
                                  class="text-danger font-weight-500"></span>
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
                            <span id="tag_name_error"
                                  class="text-danger font-weight-500"></span>
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
