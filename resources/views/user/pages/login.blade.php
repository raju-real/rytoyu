@extends('user.layouts.app')
@section('title','Login')
@push('css') @endpush

@section('content')
    <!-- BREADCRUMBS -->
    <section class="page-section breadcrumbs">
        <div class="container">
            <div class="page-header">
                <h1>Login</h1>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Login</li>
            </ul>
        </div>
    </section>
    <!-- /BREADCRUMBS -->
    <!-- PAGE -->
    <section class="page-section color">
        <div class="container">
            <section class="login-regis-area">
                <div class="login-regis-area-inner">
                    <x-alert-message />
                    <form action="{{ route('user-login') }}" class="form-login pa-login" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 hello-text-wrap">
                                <h2 class="text-center login-title">User login</h2>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group field-all">
                                    <label>Email or Mobile</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa-regular fa-mobile-phone"></i></div>
                                        <input name="email_or_mobile" type="text" class="form-control" id="email_or_mobile" placeholder="Email or Mobile">
                                    </div>
                                    @error('mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group field-all mt-10">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa-regular fa-passport"></i></div>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                        <span class="span-view"><i class="fa-regular fa-eye-slash"></i></span>
                                    </div>
                                     @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button class="btn orange-bg submit-all" href="#"><i
                                        class="fa-regular fa-paper-plane"></i>LOGIN
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-12">
                        <div class="login-other">
                            <label>login with</label>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <ul class="login-so list-inline">
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
            </section>
        </div>
    </section>
    <!-- /PAGE -->
    </div>
@endsection

@push('js') @endpush
