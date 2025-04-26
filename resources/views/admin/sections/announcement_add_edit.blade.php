@extends('admin.layouts.app')
@section('title','Announcement Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Announcement Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-outline-primary">
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
                    <form action="{{ $route }}" method="POST" id="prevent-form">
                        @csrf
                        @isset($announcement)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Title {!! starSign() !!}</label>
                                    <input type="text" name="title" value="{{ old('title') ?? $announcement->title ?? '' }}"
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
                                    <input type="text" name="highlighted_title" value="{{ old('highlighted_title') ?? $announcement->highlighted_title ?? '' }}"
                                           class="form-control {{ hasError('highlighted_title') }}"
                                           placeholder="Highlighted Title">
                                    @error('highlighted_title')
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
