@extends('admin.layouts.app')
@section('title','Seller Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Seller Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.sellers.index') }}" class="btn btn-sm btn-outline-primary">
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
                        @isset($seller)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Name {!! starSign() !!}</label>
                                    <input type="text" name="name" value="{{ old('name') ?? $seller->name ?? '' }}"
                                           class="form-control {{ hasError('name') }}"
                                           placeholder="Name">
                                    @error('name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Email {!! starSign() !!}</label>
                                    <input type="text" name="email" value="{{ old('email') ?? $seller->email ?? '' }}"
                                           class="form-control {{ hasError('email') }}"
                                           placeholder="Email">
                                    @error('email')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Mobile {!! starSign() !!}</label>
                                    <input type="text" name="mobile" value="{{ old('mobile') ?? $seller->mobile ?? '' }}"
                                           class="form-control {{ hasError('mobile') }}"
                                           placeholder="Mobile">
                                    @error('mobile')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Image (Type:jpg,jpeg,png, Max: 1MB)</label>
                                    <input type="file" name="image" class="form-control {{ hasError('image') }}" accept=".jpg,.jpeg.png">
                                    @error('image')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Password @if(!isset($seller)) {!! starSign() !!} @endif</label>
                                    <input type="text" name="password" class="form-control {{ hasError('password') }}"
                                           placeholder="Password">
                                    @error('password')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Commission Rate ( % ) @if(!isset($seller)) {!! starSign() !!} @endif</label>
                                    <input type="text" name="commission_rate" value="{{ old('commission_rate') ?? $seller->commission_rate ?? '' }}" class="form-control {{ hasError('commission_rate') }}"
                                           placeholder="Commission Rate">
                                    @error('commission_rate')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Request Status {!! starSign() !!}</label>
                                    <select name="request_status" class="form-select select2-search-disable {{ hasError('request_status') }}">
                                        @foreach(getRequestStatus() as $status)
                                            <option value="{{ $status->value }}" {{ (old('request_status') === $status->value || (isset($seller) && $seller->request_status === $status->value && empty(old('request_status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('request_status')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status {!! starSign() !!}</label>
                                    <select name="status" class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach(getStatus() as $status)
                                            <option value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($seller) && $seller->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
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
