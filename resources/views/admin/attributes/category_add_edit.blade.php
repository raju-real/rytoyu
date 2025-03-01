@extends('admin.layouts.app')
@section('title','Category Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Category Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-primary">
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
                        <input type="hidden" id="method_mode" value="{{ isset($product) ? 'PUT' : 'POST' }}">
                        @csrf
                        @isset($category)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Name {!! starSign() !!}</label>
                                    <input type="text" name="name" value="{{ old('name') ?? $category->name ?? '' }}"
                                           class="form-control {{ hasError('name') }}"
                                           placeholder="Name">
                                    @error('name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Icon (Type:png, Max: 1MB) {!! starSign() !!}</span>
                                        @if(isset($category->icon) && file_exists($category->icon))
                                            <button type="button"
                                                    class="custom-badge badge-info view-image"
                                                    data-image-url="{{ asset($category->icon) }}"
                                                    title="View Image">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <input type="file" name="icon" class="form-control {{ hasError('icon') }}"
                                           accept=".png">
                                    @error('icon')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Image (Type:jpg,jpeg,png, 750x400, Max: 1MB) {!! starSign() !!}</span>
                                        @if(isset($category->image) && file_exists($category->image))
                                            <button type="button"
                                                    class="custom-badge badge-info view-image"
                                                    data-image-url="{{ asset($category->image) }}"
                                                    title="View Image">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <input type="file" name="image" class="form-control {{ hasError('image') }}"
                                           accept=".png,.jpg,.jpeg">
                                    @error('image')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Mega Menu {!! starSign() !!}</label>
                                    <select name="is_mega_menu"
                                            class="form-select select2-search-disable {{ hasError('is_mega_menu') }}">
                                        @foreach(getConfirmStatus() as $status)
                                            <option
                                                value="{{ $status->value }}" {{ (old('is_mega_menu') === $status->value || (isset($category) && $category->is_mega_menu === $status->value && empty(old('is_mega_menu')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                        @endforeach
                                    </select>

                                    @error('is_mega_menu')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status {!! starSign() !!}</label>
                                    {{--                                    <select name="status" class="form-select  {{ hasError('status') }}">--}}
                                    {{--                                        @if(old('status'))--}}
                                    {{--                                            <option value="active" {{ old('status') === "active" ? 'selected' : '' }}>Active</option>--}}
                                    {{--                                            <option value="in-active" {{ old('status') === "in-active" ? 'selected' : '' }}>In Active</option>--}}
                                    {{--                                        @elseif(isset($category))--}}
                                    {{--                                            <option value="active" {{ $category->status === "active" ? 'selected' : '' }}>Active</option>--}}
                                    {{--                                            <option value="in-active" {{ $category->status === "in-active" ? 'selected' : '' }}>In Active</option>--}}
                                    {{--                                        @elseif(empty(old('status')) && !isset($category))--}}
                                    {{--                                            <option value="active" selected>Active</option>--}}
                                    {{--                                            <option value="in-active">In Active</option>--}}
                                    {{--                                        @endif--}}
                                    {{--                                    </select>--}}
                                    {{--                                    <select name="status" class="form-select {{ hasError('status') }}">--}}
                                    {{--                                        <option value="active" {{ (old('status') === "active" || (isset($category) && $category->status === "active" && empty(old('status')))) ? 'selected' : '' }}>Active</option>--}}
                                    {{--                                        <option value="in-active" {{ (old('status') === "in-active" || (isset($category) && $category->status === "in-active" && empty(old('status')))) ? 'selected' : '' }}>In Active</option>--}}
                                    {{--                                    </select>--}}

                                    <select name="status"
                                            class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach(getStatus() as $status)
                                            <option
                                                value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($category) && $category->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                        @endforeach
                                    </select>

                                    @error('status')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Banner Images
                                                <strong class="badge badge-pill badge-info">(Type:jpg,jpeg,png,
                                                    Max:1MB, Rc: 775x230)</strong>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @error('banner_images')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                            @foreach ($errors->get('banner_images.*') as $key => $messages)
                                                @foreach ($messages as $message)
                                                    <div class="alert alert-danger">
                                                        {{ $message }}</div>
                                                @endforeach
                                            @endforeach

                                            <table class="table table-responsive table-stripped w-100"
                                                   id="banner_image_table">
                                                <thead>
                                                <tr class="form-label">
                                                    <th>Image{!! starSign() !!}</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if (isset($category) && count($category->banner_images))
                                                    <input type="hidden" id="total_banner_images"
                                                           value="{{ $category->total_banner_images }}">
                                                    @foreach ($category->banner_images as $key => $image)
                                                        <tr data-index="{{ $key }}">
                                                            <td class="w-85">
                                                                {{--Hidden inputs--}}
                                                                <input type="hidden"
                                                                       name="banner_images[{{ $key }}][is_new]"
                                                                       value="0">
                                                                <input type="hidden"
                                                                       name="banner_images[{{ $key }}][index_no]"
                                                                       value="{{ $key }}">
                                                                <input type="hidden"
                                                                       name="banner_images[{{ $key }}][id]"
                                                                       value="{{ $image->id }}">
                                                                {{--file input--}}
                                                                <input type="file"
                                                                       name="banner_images[{{ $key }}][image]"
                                                                       id="banner_image_{{ $key }}"
                                                                       class="form-control" accept=".jpg,.jpeg,.png">
                                                            </td>
                                                            <td class="w-15 float-end">
                                                                <!-- View Image Link -->
                                                                @if ($image->image && file_exists($image->image))
                                                                    <button type="button"
                                                                            class="btn btn-md btn-info view-image"
                                                                            data-image-url="{{ asset($image->image) }}"
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
                            <x-submit-button></x-submit-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/category_add_edit.js') }}"></script>
@endpush
