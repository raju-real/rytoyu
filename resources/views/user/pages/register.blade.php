@extends('user.layouts.app')
@section('title','Home')
@push('css') @endpush

@section('content')
    <!-- CONTENT AREA -->
    <div class="content-area">
        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs">
            <div class="container">
                <div class="page-header">
                    <h1>Sign up</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">Sign up</li>
                </ul>
            </div>
        </section>
        <!-- /BREADCRUMBS -->
        <!-- PAGE -->
        <section class="page-section color">
            <div class="container">
                <section class="login-regis-area p-20">
                    <form action="{{ route('user-register') }}" class="form-login" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 hello-text-wrap">
                                <div class="registration-top">
                                    <h2 class="text-center login-title">Create an account</h2>
                                    <div class="or-block">
                                        <span>or</span>
                                    </div>
                                    <div class="sign-other">
                                        <ul class="login-so list-inline">
                                            <label>Sign in with: </label>
                                            <li>
                                                <a href=""><i class="fa-brands fa-facebook-f"></i></a>
                                            </li>
                                            <li>
                                                <a href=""><i class="fa-brands fa-instagram"></i></a>
                                            </li>
                                            <li>
                                                <a href=""><i class="fa-brands fa-google"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-0">
                                <div class="col-md-6">
                                    <div class="form-group field-all">
                                        <label>First Name</label> {!! starSign() !!}
                                        <div class="input-group w-full">
                                            <input name="first_name" type="text" class="form-control" id="first_name"
                                                   value="{{ old('first_name') ?? '' }}"
                                                   placeholder="First Name">
                                        </div>
                                        @error('first_name')
                                        {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group field-all">
                                        <label>Last Name</label> {!! starSign() !!}
                                        <div class="input-group w-full">
                                            <input name="last_name" type="text" class="form-control" id="last_name"
                                                   value="{{ old('last_name') ?? '' }}"
                                                   placeholder="Last Name">
                                        </div>
                                        @error('last_name')
                                        {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group field-all">
                                        <label>Email</label> {!! starSign() !!}
                                        <div class="input-group w-full">
                                            <input name="email" type="mail" class="form-control" id="email"
                                                   value="{{ old('email') ?? '' }}"
                                                   placeholder="Email">
                                        </div>
                                        @error('email')
                                        {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group field-all">
                                        <label>Mobile</label>
                                        <div class="input-group w-full">
                                            <input name="mobile" type="number" class="form-control" id="mobile"
                                                   value="{{ old('mobile') ?? '' }}"
                                                   placeholder="Mobile">
                                        </div>
                                        @error('mobile')
                                        {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            {{--                            <div class="col-md-6">--}}
                            {{--                                <div class="form-group field-all">--}}
                            {{--                                    <label>Gender</label>--}}
                            {{--                                    <div class="input-group w-full">--}}

                            {{--                                        <select id="" class="form-control sel-bg">--}}
                            {{--                                            <option selected>Select gender</option>--}}
                            {{--                                            <option>Male</option>--}}
                            {{--                                            <option>Female</option>--}}
                            {{--                                        </select>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="col-md-6">--}}
                            {{--                                <div class="form-group field-all">--}}
                            {{--                                    <label>Age</label>--}}
                            {{--                                    <div class="input-group w-full">--}}
                            {{--                                        <input type="text" class="form-control" id="" placeholder="">--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <div class="col-md-6">
                                <div class="form-group field-all ">
                                    <label>Password</label> {!! starSign() !!}
                                    <div class="input-group w-full">
                                        <input name="password" type="password" class="form-control" id="password"
                                               placeholder="Password">
                                        <span class="span-view"><i class="fa-regular fa-eye-slash"></i></span>
                                    </div>
                                    @error('password')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group field-all ">
                                    <label>Confirm Password</label> {!! starSign() !!}
                                    <div class="input-group w-full">
                                        <input name="confirm_password" type="password" class="form-control" id=""
                                               placeholder="Confirm Password">
                                        <span class="span-view"><i class="fa-regular fa-eye-slash"></i></span>
                                    </div>
                                    @error('confirm_password')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mt-10">
                                <p class="mt-10 font-sizep mb-0"><strong>Address</strong></p>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group field-all">
                                    <label>District</label> {!! starSign() !!}
                                    <div class="input-group w-full">
                                        <select name="district_id" id="" class="form-control sel-bg">
                                            <option selected>Select City</option>
                                            <option value="1" {{ old('district_id') == 1 ? 'selected' : '' }}>Dhaka</option>
                                            <option value="2" {{ old('district_id') == 2 ? 'selected' : '' }}>Rangpur</option>
                                        </select>
                                    </div>
                                    @error('district_id')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group field-all ">
                                    <label>City</label>
                                    <div class="input-group w-full">
                                        <input name="city" type="text" class="form-control" id="city"
                                               value="{{ old('city') ?? '' }}"
                                               placeholder="City">
                                    </div>
                                    @error('city')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group field-all ">
                                    <label>Zip Code</label>
                                    <div class="input-group w-full">
                                        <input name="zip_code" type="text" class="form-control" id="zip_code"
                                               value="{{ old('zip_code') ?? '' }}"
                                               placeholder="Zip Code">
                                    </div>
                                    @error('zip_code')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group field-all ">
                                    <label>Delivery Address</label>
                                    <div class="input-group w-full">
                                        <input name="delivery_address" type="text" class="form-control"
                                               id="delivery_address" value="{{ old('delivery_address') ?? '' }}" placeholder="Delivery Address">
                                    </div>
                                    @error('delivery_address')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn orange-bg submit-all">
                                    <i class="fa-regular fa-paper-plane"></i>CREATE
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </section>
        <!-- /PAGE -->
    </div>
    <!-- /CONTENT AREA -->
@endsection

@push('js') @endpush
