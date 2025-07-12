@extends('user.layouts.app')
@section('title','Profile')
@push('css') @endpush

@section('content')
    <section class="page-section">
        <div class="wrap container">
            <div class="row">
                <!--start sidebar-->
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="widget account-details">
                        <h2 class="widget-title">Account</h2>
                        @include('user.account.menus')
                    </div>
                </div>
                <!--end sidebar-->
                <!--start main contain of page-->
                <div class="col-lg-9 col-md-9 col-sm-8">
                    <div class="information-title">Your Account Information</div>
                    <div class="details-wrap">
                        <div class="block-title alt"><i class="fa fa-angle-down"></i> Change Your Personal Details</div>
                        @if(Auth::user()->need_change_password)
                            <div class="alert alert-success">
                                <strong>You should change your password. </strong>
                                <a href="{{ route('change-password') }}" class="alert-link">Click here</a> to change.
                            </div>
                        @endif
                        @if(Auth::user()->need_change_mobile)
                            <div class="alert alert-success">
                                <strong>You should change your mobile. </strong>
                                <a href="{{ route('change-mobile') }}" class="alert-link">Click here</a> to change.
                            </div>
                        @endif

                        @if(Auth::user()->mobile_verified_at == null)
                            <div class="alert alert-success">
                                <strong>You should verify your mobile. </strong>
                                <a href="{{ route('verify-user-mobile') }}" class="alert-link">Click here</a> to verify.
                            </div>
                        @endif
                        <div class="details-box">
                            @if(Session::has('message'))
                                <p class="alert alert-info">{{ Session::get('message') }}</p>
                            @endif
                            <form action="{{ route('update-user-profile') }}" method="POST" class="form-delivery">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="first_name" id="first_name" class="form-control" type="text"
                                                   placeholder="First Name" value="{{ $user->first_name ?? '' }}">
                                            @error('first_name')
                                            {!! displayError($message) !!}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="last_name" id="last_name" class="form-control" type="text"
                                                   placeholder="Last Name" value="{{ $user->last_name ?? '' }}">
                                            @error('last_name')
                                            {!! displayError($message) !!}
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group selectpicker-wrapper">
                                            <select id="district" name="district" class="form-control sel-bg">
                                                @foreach (allDistrict() as $district)
                                                    <option value="{{ $district->slug }}"
                                                        {{ $user->district_id == $district->id ? 'selected' : '' }}>
                                                        {{ $district->district_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                            @error('district')
                                            {!! displayError($message) !!}
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="city" id="city" class="form-control" type="text"
                                                   placeholder="City"
                                                   value="{{ $user->city ?? '' }}">
                                            @error('city')
                                            {!! displayError($message) !!}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="zip_code" id="zip_code" class="form-control" type="text"
                                                   placeholder="Postcode/ZIP" value="{{ $user->zip_code ?? '' }}">
                                            @error('zip_code')
                                            {!! displayError($message) !!}
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="address" id="address" class="form-control" type="text"
                                                   placeholder="Address" value="{{ $user->delivery_address ?? '' }}">
                                            @error('address')
                                            {!! displayError($message) !!}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 text-right">
                                        <button class="btn btn-theme btn-upa" type="submit"> Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end main contain of page-->

            </div>
        </div>
    </section>
@endsection

@push('js') @endpush
