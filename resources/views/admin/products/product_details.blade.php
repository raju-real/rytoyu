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
                            <td>{{ $product->name ?? '' }}</td>
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
                            <td>Exchangeable ? </td>
                            <td>:</td>
                            <td>{{ $product->is_exchangable == 1 ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td>Refundable ? </td>
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
                            <td>{!! $product->short_description ?? '' !!}</td>
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
