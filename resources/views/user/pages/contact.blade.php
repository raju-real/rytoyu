@extends('user.layouts.app')
@section('title','Contact')

@section('content')
    <!-- BREADCRUMBS -->
    <section class="page-section breadcrumbs">
        <div class="container">
            <div class="page-header">
                <h1>Contact</h1>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Contact</li>
            </ul>
        </div>
    </section>
    <!-- /BREADCRUMBS -->
    <!-- PAGE -->
    <section class="page-section color">
        <div class="container">
            <section class="login-regis-area">
                <div class="login-regis-area-inner">
                    @if(Session::has('message'))
                        <div class="alert alert-{{ Session::get("type", "info") }}" role="alert">
                            <span class="font-weight-500">{{ Session::get('message') }}</span>
                        </div>
                    @endif
                    <form action="{{ route('send-contact-message') }}" class="form-login pa-login" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
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

                            <div class="col-md-12">
                                <div class="form-group field-all">
                                    <label>Email</label> {!! starSign() !!}
                                    <div class="input-group w-full">
                                        <input name="email" type="text" class="form-control" id="email"
                                               value="{{ old('email') ?? '' }}"
                                               placeholder="Email">
                                    </div>
                                    @error('full_name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group field-all">
                                    <label>Mobile</label> {!! starSign() !!}
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

                            <div class="col-md-12">
                                <div class="form-group field-all">
                                    <label>Subject</label> {!! starSign() !!}
                                    <div class="input-group w-full">
                                        <input name="subject" type="text" class="form-control" id="subject"
                                               value="{{ old('subject') ?? '' }}"
                                               placeholder="Subject">
                                    </div>
                                    @error('subject')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Message</label> {!! starSign() !!}
                                    <textarea name="message" id="message" class="form-control"
                                              placeholder="Message"
                                              style="height: 150px;">{{ old('message') ?? '' }}</textarea>
                                </div>
                                @error('message')
                                {!! displayError($message) !!}
                                @enderror
                            </div>

                            <div class="col-md-12 text-right">
                                <button class="btn orange-bg submit-all" href="#"><i
                                        class="fa-regular fa-paper-plane"></i>Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </section>
    <!-- /PAGE -->
    </div>
@endsection

@push('js') @endpush
