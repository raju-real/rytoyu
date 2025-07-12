@extends('user.layouts.app')
@section('title','Join Request')
@push('css')
    <style>
        .basic-information {
            font-size: medium !important;
            color: chocolate !important;
        }
    </style>

@endpush

@section('content')
    <!-- CONTENT AREA -->
    <div class="content-area">
        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs">
            <div class="container">
                <div class="page-header">
                    <h1>Join Request</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">Join Request</li>
                </ul>
            </div>
        </section>
        <!-- /BREADCRUMBS -->
        <!-- PAGE -->
        <section class="page-section color">
            <div class="container">
                @if(session('message'))
                    <p class="alert alert-info">{{ session('message') }}</p>
                @endif
                <section class="login-regis-area p-20">
                    <form action="{{ route('send-join-request') }}" class="form-login" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 hello-text-wrap">
                                <div class="registration-top">
                                    <h2 class="text-left login-title">
                                        Submit join request
                                        <br>
                                        <span class="basic-information font-weight-500">Share your basic information, and our team will connect with you to guide you through the next steps.</span>
                                    </h2>
                                </div>

                            </div>

                            <div class="row m-0">
                                <div class="col-md-6">
                                    <div class="form-group field-all">
                                        <label>Name</label> {!! starSign() !!}
                                        <div class="input-group w-full">
                                            <input name="name" type="text" class="form-control" id="name"
                                                   value="{{ old('name') ?? '' }}"
                                                   placeholder="Name">
                                        </div>
                                        @error('name')
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
                                        <label>Mobile {!! starSign() !!}</label>
                                        <div class="input-group w-full">
                                            <input name="mobile" type="text" class="form-control" id="mobile"
                                                   value="{{ old('mobile') ?? '' }}"
                                                   placeholder="Mobile">
                                        </div>
                                        @error('mobile')
                                        {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group field-all ">
                                        <label>Curriculum Vitae</label> {!! starSign() !!}
                                        <div class="input-group w-full">
                                            <input name="curriculum_vitae" type="file" class="form-control" id="curriculum_vitae"
                                                   placeholder="curriculum_vitae" accept=".pdf">
                                        </div>
                                        @error('curriculum_vitae')
                                        {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn orange-bg submit-all">
                                    <i class="fa-regular fa-paper-plane"></i>Submit
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
