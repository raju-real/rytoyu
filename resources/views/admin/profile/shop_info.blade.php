@extends('admin.layouts.app')
@section('title', 'Shop Info')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Shop Info</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.update-shop-info') }}" method="POST" id="prevent-form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Shop Name {!! starSign() !!}</label>
                                    <input type="text" name="shop_name" value="{{ authShopInfo()->shop_name ?? '' }}"
                                        class="form-control {{ hasError('shop_name') }}" placeholder="Shop Name">
                                    @error('shop_name')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Email {!! starSign() !!}</label>
                                    <input type="text" name="email" value="{{ authShopInfo()->email ?? '' }}"
                                        class="form-control {{ hasError('email') }}" placeholder="Email">
                                    @error('email')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Mobile {!! starSign() !!}</label>
                                    <input type="text" name="mobile" value="{{ authShopInfo()->mobile ?? '' }}"
                                        class="form-control {{ hasError('mobile') }}" placeholder="Mobile">
                                    @error('mobile')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" value="{{ authShopInfo()->phone ?? '' }}"
                                        class="form-control {{ hasError('phone') }}" placeholder="Phone">
                                    @error('phone')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Start From</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="start_from" class="form-control datepicker"
                                                autocomplete="off"
                                                value="{{ old('start_from') ?? (authShopInfo()->start_from ?? '') }}"
                                                placeholder="Start From" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-calendar"></i> </span>
                                            </div>

                                        </div>
                                        @error('start_from')
                                            {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Logo (Type: jpg, jpeg, png, Max: 1MB)</span>
                                        @if (isset(authShopInfo()->logo) && file_exists(authShopInfo()->logo))
                                            <button type="button" class="custom-badge badge-info view-image"
                                                data-image-url="{{ asset(authShopInfo()->logo) }}" title="View Image">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <input type="file" name="logo" class="form-control {{ hasError('logo') }}"
                                        accept=".jpg,.jpg,.png">
                                    @error('logo')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Licence No</label>
                                    <input type="text" name="licence_no" value="{{ authShopInfo()->licence_no ?? '' }}"
                                        class="form-control {{ hasError('licence_no') }}" placeholder="Licence No">
                                    @error('licence_no')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Licence Photo (Type: jpg, jpeg, png, Max: 1MB)</span>
                                        @if (isset(authShopInfo()->licence_file) && file_exists(authShopInfo()->licence_file))
                                            <button type="button" class="custom-badge badge-info view-image"
                                                data-image-url="{{ asset(authShopInfo()->licence_file) }}"
                                                title="View Image">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <input type="file" name="licence_file"
                                        class="form-control {{ hasError('licence_file') }}" accept=".jpg,.jpg.png">
                                    @error('licence_file')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Website URL</label>
                                    <input type="text" name="website_url"
                                        value="{{ authShopInfo()->website_url ?? '' }}"
                                        class="form-control {{ hasError('website_url') }}" placeholder="Website URL">
                                    @error('website_url')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" id="address" cols="30" rows="1"
                                        class="form-control {{ hasError('address') }}" placeholder="Address">{{ old('address') ?? (authShopInfo()->address ?? '') }}</textarea>
                                    @error('address')
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
