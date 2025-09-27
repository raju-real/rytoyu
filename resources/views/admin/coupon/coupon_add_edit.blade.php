@extends('admin.layouts.app')
@section('title','Coupon Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Coupon Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-sm btn-outline-primary">
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
                        @isset($coupon)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Valid For {!! starSign() !!}</label>
                                    <select name="valid_for" class="form-select select2-search-disable {{ hasError('valid_for') }}">
                                        @foreach(getValidForUser() as $user)
                                            <option value="{{ $user->value }}" {{ (old('valid_for') === $user->value || (isset($coupon) && $coupon->valid_for === $user->value && empty(old('valid_for')))) ? 'selected' : '' }}>{{ $user->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('valid_for')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Coupon Code {!! starSign() !!}</label>
                                    <input type="text" name="coupon_code" value="{{ old('coupon_code') ?? $coupon->coupon_code ?? '' }}"
                                           class="form-control {{ hasError('coupon_code') }}"
                                           placeholder="Coupon Code">
                                    @error('coupon_code')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Discount Type {!! starSign() !!}</label>
                                    <select name="discount_type" class="form-select select2-search-disable {{ hasError('discount_type') }}">
                                        @foreach(discountTypes() as $type)
                                            <option value="{{ $type->value }}" {{ (old('discount_type') === $type->value || (isset($coupon) && $coupon->discount_type === $type->value && empty(old('discount_type')))) ? 'selected' : '' }}>{{ $type->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('discount_type')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Discount {!! starSign() !!}</label>
                                    <input type="number" name="discount" value="{{ old('discount') ?? $coupon->discount ?? '' }}"
                                           class="form-control {{ hasError('discount') }}"
                                           placeholder="Discount">
                                    @error('discount')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Used Limit {!! starSign() !!}</label>
                                    <input type="number" name="used_limit" value="{{ old('used_limit') ?? $coupon->used_limit ?? '' }}"
                                           class="form-control {{ hasError('used_limit') }}"
                                           placeholder="Used Limit">
                                    @error('used_limit')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Minimum Cost {!! starSign() !!}</label>
                                    <input type="number" name="minimum_cost" value="{{ old('minimum_cost') ?? $coupon->minimum_cost ?? '' }}"
                                           class="form-control {{ hasError('minimum_cost') }}"
                                           placeholder="Minimum Cost">
                                    @error('minimum_cost')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Up To <i class="fa fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Max discount amount."></i> {!! starSign() !!}</label>
                                    <input type="number" name="up_to" value="{{ old('up_to') ?? $coupon->up_to ?? '' }}"
                                           class="form-control {{ hasError('up_to') }}"
                                           placeholder="Up To">
                                    @error('up_to')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Start Date</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="start_date" class="form-control datepicker"
                                                autocomplete="off"
                                                value="{{ old('start_date') ?? $coupon->start_date ?? '' }}"
                                                placeholder="Start Date" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-calendar"></i> </span>
                                            </div>

                                        </div>
                                        @error('start_date')
                                            {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>End Date</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="end_date" class="form-control datepicker"
                                                autocomplete="off"
                                                value="{{ old('end_date') ?? $coupon->end_date ?? '' }}"
                                                placeholder="End Date" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-calendar"></i> </span>
                                            </div>

                                        </div>
                                        @error('end_date')
                                            {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status {!! starSign() !!}</label>
                                    <select name="status" class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach(getStatus() as $status)
                                            <option value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($coupon) && $coupon->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
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


