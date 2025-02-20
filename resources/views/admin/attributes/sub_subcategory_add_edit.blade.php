@extends('admin.layouts.app')
@section('title','Sub Subcategory Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sub Subcategory Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.sub-subcategories.index') }}" class="btn btn-sm btn-outline-primary">
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
                    <form action="{{ $route }}" method="POST" id="prevent-form" enctype="multipart/form-data">
                        @csrf
                        @isset($sub_subcategory)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Name {!! starSign() !!}</label>
                                    <input type="text" name="name" value="{{ old('name') ?? $sub_subcategory->name ?? '' }}"
                                           class="form-control {{ hasError('name') }}"
                                           placeholder="Name">
                                    @error('name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Category {!! starSign() !!}</label>
                                    <select name="category" id="category" class="form-control select2 {{ hasError('category') }} ">
                                        <option value="">Select Category</option>
                                        @foreach(activeCategories() as $category)
                                            <option value="{{ $category->id }}" {{ old('category') == $category->id || isset($sub_subcategory) && $sub_subcategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Sub Category {!! starSign() !!}</label>
                                    <select name="subcategory" id="subcategory" class="form-control select2 {{ hasError('subcategory') }} " data-old-value="{{ $sub_subcategory->subcategory_id ?? old('subcategory')  }}">
                                        <option value="">Select Sub Category</option>
                                        @isset($sub_subcategory)
                                            <option value="{{ $sub_subcategory->subcategory_id }}" selected>{{ $sub_subcategory->subcategory->name ?? '' }}</option>
                                        @endisset
                                    </select>
                                    @error('subcategory')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Icon (Type:png, Max: 1MB)</label>
                                    <input type="file" name="icon" class="form-control {{ hasError('icon') }}" accept=".jpg,jpeg,.png">
                                    @error('icon')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status {!! starSign() !!}</label>
                                    <select name="status" class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach(getStatus() as $status)
                                            <option value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($sub_subcategory) && $sub_subcategory->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    {!! displayError($message) !!}
                                    @enderror
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
    <script src="{{ asset('assets/admin/js/custom/sub_sub_category.js') }}"></script>
@endpush

