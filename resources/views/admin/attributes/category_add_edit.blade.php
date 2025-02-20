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
                                    <label class="form-label">Icon (Type:png, Max: 1MB)</label>
                                    <input type="file" name="icon" class="form-control {{ hasError('icon') }}" accept=".png">
                                    @error('icon')
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

                                    <select name="status" class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach(getStatus() as $status)
                                            <option value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($category) && $category->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
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

@push('js') @endpush
