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
                            <form class="form-delivery" action="#">
                                <div class="all-form">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group"><input required type="text" placeholder="First Name"
                                                                           class="form-control"></div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group"><input required type="text" placeholder="Last Name"
                                                                           class="form-control"></div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group"><input required type="text" placeholder="Gender"
                                                                           class="form-control"></div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group"><input required type="text" placeholder="Email"
                                                                           class="form-control"></div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group"><input required type="text"
                                                                           placeholder="Phone Number"
                                                                           class="form-control"></div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group"><input type="text" placeholder="Fax"
                                                                           class="form-control"></div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 text-right">
                                            <button class="btn btn-theme btn-upa" type="submit"> Update</button>
                                        </div>
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
