@extends('admin.layouts.app')
@section('title','Delivery Charge Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Delivery Charge Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.delivery-charges.index') }}" class="btn btn-sm btn-outline-primary">
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
                        @isset($charge)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">District Name {!! starSign() !!}</label>
                                    <input type="text" name="district_name" value="{{ old('district_name') ?? $charge->district_name ?? '' }}"
                                           class="form-control {{ hasError('district_name') }}"
                                           placeholder="District Name">
                                    @error('district_name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Delivery Charge {!! starSign() !!}</label>
                                    <input type="text" name="delivery_charge" value="{{ old('delivery_charge') ?? $charge->delivery_charge ?? '' }}"
                                           class="form-control {{ hasError('delivery_charge') }}"
                                           placeholder="Delivery Charge">
                                    @error('delivery_charge')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status {!! starSign() !!}</label>
                                    <select name="status" class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach(getStatus() as $status)
                                            <option value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($charge) && $charge->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
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
