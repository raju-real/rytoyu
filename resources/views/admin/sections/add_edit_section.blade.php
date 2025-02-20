@extends('admin.layouts.app')
@section('title','Section Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Section Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.sections') }}" class="btn btn-sm btn-outline-primary">
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
                        @isset($section)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Sorting Serial (Not Editable)</label>
                                    <input type="text"
                                           value="{{ old('sorting_serial') ?? $section->sorting_serial ?? $sorting_serial ?? 0 }}"
                                           class="form-control {{ hasError('sorting_serial') }}"
                                           placeholder="Sorting Serial" readonly>
                                    @error('name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Title {!! starSign() !!}</label>
                                    <input type="text" name="section_title"
                                           value="{{ old('section_title') ?? $section->section_title ?? '' }}"
                                           class="form-control {{ hasError('section_title') }}"
                                           placeholder="Title">
                                    @error('section_title')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            @if(!isset($section) || (isset($section) && $section->section_module === 'custom'))
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Section For {!! starSign() !!}</label>
                                        <select name="section_for"
                                                class="form-select select2-search-disable {{ hasError('section_for') }}">
                                            @foreach(webSectionFor() as $web_section)
                                                <option
                                                    value="{{ $web_section->value }}" {{ (old('section_for') === $web_section->value || (isset($section) && $section->section_for === $web_section->value && empty(old('section_for')))) ? 'selected' : '' }}>{{ $web_section->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status {!! starSign() !!}</label>
                                    <select name="status"
                                            class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach(getStatus() as $status)
                                            <option
                                                value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($section) && $section->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
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
