@extends('admin.layouts.app')
@section('title','Product Type Category Bound')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Product Type Category Bound</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.manage-product-types') }}" class="btn btn-sm btn-outline-primary">
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
                    <form action="{{ route('admin.bound-category-on-product-type',$type->id) }}" method="POST"
                          id="prevent-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Product Type</label>
                                    <input type="text" value="{{ $type->name ?? '' }}" class="form-control" readonly>
                                    @error('name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">Categories</label>
                                    <select name="category_ids[]"
                                            class="form-control select2 product_tags product-input-control"
                                            multiple="multiple"
                                            data-placeholder="Categories ...">
                                        <option value="">Select Categories</option>
                                        @foreach($categories as $category)
                                            <option
                                                value="{{ $category->id }}" {{ in_array($category->id,$type->category_ids) ? 'selected' : '' }}>{{ $category->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div>
                            <x-submit-button></x-submit-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
