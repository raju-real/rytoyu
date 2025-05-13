@extends('user.layouts.app')
@section('title','Verify Mobile')
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
                    <div class="information-title">Verify Mobile</div>
                    <div class="details-wrap">
                        <div class="block-title alt"><i class="fa fa-angle-down"></i> Verify Mobile</div>
                        <div class="details-box">
                            <div class="all-form">
                                @if(Session::has('message'))
                                    <p class="alert alert-info">{{ Session::get('message') }}</p>
                                @endif
                                <p class="alert alert-info" id="success-message" style="display: none"></p>
                                <div class="row" id="mobile-section">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <input id="mobile" type="text"
                                                   placeholder="New Mobile"
                                                   class="form-control" value="{{ Auth::user()->mobile ?? '' }}"
                                                   readonly>
                                            <small class="text-danger font-weight-500 mobile-error"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 text-right">
                                        <button class="btn btn-theme btn-upa" id="send-code-btn" type="button"> Send
                                            Verification Code
                                        </button>
                                    </div>
                                </div>

                                <div class="row" id="verification-section" style="display: none;">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <input type="text"
                                                   placeholder="Enter Verification Code"
                                                   class="form-control"
                                                   id="verification-code"
                                            >
                                            <span class="verification-code-error font-weight-500 text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 text-right">
                                        <button id="verify-code-btn" class="btn btn-theme btn-upa" type="button"> Verify
                                            Code
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end main contain of page-->

            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('assets/user/js/mobile_verification.js') }}"></script>
@endpush
