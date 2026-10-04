@extends('admin.layouts.app')
@section('title','Product Details')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Product Details</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-arrow-circle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Product Thumbnail</h4>
                    @if ($product->thumbnail_path != null && file_exists($product->thumbnail_path))
                        <img src="{{ asset($product->thumbnail_path) }}"
                             class="img-responsive rounded-3 d-block" style="height: 500px;width: 100%">
                    @else
                        <img src="{{ asset('assets/common/images/ecommerce.png') }}"
                             class="img-responsive rounded-3 d-block" style="height: 500px;width: 100%">
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Product Images</h4>
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            @foreach($product->images as $image)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img class="d-block img-responsive"
                                         src="{{ asset($image->image_path) }}"
                                         alt="First slide" style="height: 500px;width: 100%">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                           data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                           data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-md table-bordered table-striped">
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>{!! showStatus($product->status) !!}</td>
                        </tr>
                        <tr>
                            <td>Code/SKU</td>
                            <td>:</td>
                            <td>{{ $product->product_code ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td {!! tooltip($product->name ?? '') !!}>{{ textLimit($product->name ?? '') }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>:</td>
                            <td>{{ $product->type->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>:</td>
                            <td>{{ $product->category->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Subcategory</td>
                            <td>:</td>
                            <td>{{ $product->subcategory->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Sub Subcategory</td>
                            <td>:</td>
                            <td>{{ $product->sub_subcategory->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Brand</td>
                            <td>:</td>
                            <td>{{ $product->brand->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Variants</td>
                            <td>:</td>
                            <td>
                                <table class="table table-info table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <td class="text-center">Sl.no</td>
                                        <td>Size</td>
                                        <td>Color</td>
                                        <td>Unit Price</td>
                                        <td>Discount Price</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product->variants as $variant)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td>{{ $variant->size_name ?? '' }}</td>
                                            <td>{{ $variant->color_name ?? '' }}</td>
                                            <td>{{ numberFormat($variant->unit_price) ?? '' }}</td>
                                            <td>{{ numberFormat($variant->discount_price) ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>Default Unit Price</td>
                            <td>:</td>
                            <td>{{ $product->unit_price ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Default Discount Price</td>
                            <td>:</td>
                            <td>{{ $product->discount_price ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Unit</td>
                            <td>:</td>
                            <td>{{ $product->unit->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Tags</td>
                            <td>:</td>
                            <td>{{ $product->product_tags ?? '' }}</td>
                        </tr>

                        <tr>
                            <td>Exchangeable ?</td>
                            <td>:</td>
                            <td>{{ $product->is_exchangable == 1 ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td>Refundable ?</td>
                            <td>:</td>
                            <td>{{ $product->is_refundable == 1 ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td>Video Link</td>
                            <td>:</td>
                            <td>{{ $product->video_link ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Warranty</td>
                            <td>:</td>
                            <td>{{ $product->warranty ?? '' }}</td>
                        </tr>

                        <tr>
                            <td>Short Description</td>
                            <td>:</td>
                            <td>{!! $product->short_description ?? '' !!}</td>
                        </tr>
                        <tr>
                            <td>Special Note</td>
                            <td>:</td>
                            <td>{{ $product->special_note ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Details</td>
                            <td>:</td>
                            <td>{!! $product->product_details ?? '' !!}</td>
                        </tr>
                        <tr>
                            <td>Specification</td>
                            <td>:</td>
                            <td>{!! $product->product_specification ?? '' !!}</td>
                        </tr>
                        <tr>
                            <td>Compare</td>
                            <td>:</td>
                            <td>{!! $product->product_compare ?? '' !!}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
