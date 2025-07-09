@extends('admin.layouts.app')
@section('title','Faq Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Faq Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-outline-primary">
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
                        @isset($faq)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Question {!! starSign() !!}</label>
                                    <input type="text" name="question" value="{{ old('question') ?? $faq->question ?? '' }}"
                                           class="form-control {{ hasError('question') }}"
                                           placeholder="Question">
                                    @error('question')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Answer {!! starSign() !!}</label>
                                    <textarea name="answer" class="form-control {{ hasError('answer') }}" placeholder="Answer">{{ old('answer') ?? $faq->answer ?? '' }}</textarea>
                                    @error('answer')
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
