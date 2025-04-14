@extends('admin.layouts.app')
@section('title','Slider Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Slider Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-sm btn-outline-primary">
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
                        @isset($slider)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Title {!! starSign() !!}</label>
                                    <input type="text" name="title" value="{{ old('title') ?? $slider->title ?? '' }}"
                                           class="form-control {{ hasError('title') }}"
                                           placeholder="Title">
                                    @error('title')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Highlighted Title {!! starSign() !!}</label>
                                    <input type="text" name="highlighted_title" value="{{ old('highlighted_title') ?? $slider->highlighted_title ?? '' }}"
                                           class="form-control {{ hasError('highlighted_title') }}"
                                           placeholder="Highlighted Title">
                                    @error('highlighted_title')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Caption {!! starSign() !!}</label>
                                    <input type="text" name="caption" value="{{ old('caption') ?? $slider->caption ?? '' }}"
                                           class="form-control {{ hasError('caption') }}"
                                           placeholder="Caption">
                                    @error('caption')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Highlighted Caption {!! starSign() !!}</label>
                                    <input type="text" name="highlighted_caption" value="{{ old('highlighted_caption') ?? $slider->highlighted_caption ?? '' }}"
                                           class="form-control {{ hasError('highlighted_caption') }}"
                                           placeholder="Highlighted Caption">
                                    @error('highlighted_caption')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Image (Type:jpg,jpeg,png, 1440x540, Max: 1MB) {!! starSign() !!}</span>
                                        @if(isset($slider->image_path) && file_exists($slider->image_path))
                                            <button type="button"
                                                    class="custom-badge badge-info view-image"
                                                    data-image-url="{{ asset($slider->image_path) }}"
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
                                    <label class="form-label">Button Name (Default: 'Shop Now')</label>
                                    <input type="text" name="button_name" value="{{ old('button_name') ?? $slider->button_name ?? '' }}"
                                           class="form-control {{ hasError('button_name') }}"
                                           placeholder="Button Name">
                                    @error('button_name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Redirect Link</label>
                                    <input type="text" name="redirect_link" value="{{ old('redirect_link') ?? $slider->redirect_link ?? '' }}"
                                           class="form-control {{ hasError('redirect_link') }}"
                                           placeholder="Redirect Link">
                                    @error('redirect_link')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status {!! starSign() !!}</label>
                                    <select name="status"
                                            class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach(getStatus() as $status)
                                            <option
                                                value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($slider) && $slider->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
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
@endpush
