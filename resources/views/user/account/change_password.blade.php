@extends('user.layouts.app')
@section('title','Change Password')
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
                    <div class="information-title">Change Password</div>
                    <div class="details-wrap">
                        <div class="block-title alt"><i class="fa fa-angle-down"></i> Change Your Password</div>
                        <div class="details-box">
                            @if(Session::has('message'))
                                <p class="alert alert-info">{{ Session::get('message') }}</p>
                            @endif
                            @if(Auth::user()->need_change_password)
                                <form class="form-delivery" action="{{ route("update-initial-password") }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="all-form">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-4">
                                                <div class="form-group">
                                                    <input name="new_password" type="password"
                                                           placeholder="New Password"
                                                           class="form-control">
                                                </div>
                                                @error('new_password')
                                                {!! displayError($message) !!}
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-sm-4">
                                                <div class="form-group">
                                                    <input name="confirm_password" type="password"
                                                           placeholder="Confirm Password"
                                                           class="form-control">
                                                </div>
                                                @error('confirm_password')
                                                {!! displayError($message) !!}
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-sm-12 text-right">
                                                <button class="btn btn-theme btn-upa" type="submit"> Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form class="form-delivery" action="{{ route("update-password") }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="all-form">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-4">
                                                <div class="form-group">
                                                    <input name="current_password" type="password"
                                                           placeholder="Current Password"
                                                           class="form-control">
                                                </div>
                                                @error('current_password')
                                                {!! displayError($message) !!}
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-sm-4">
                                                <div class="form-group">
                                                    <input name="new_password" type="password"
                                                           placeholder="New Password"
                                                           class="form-control">
                                                </div>
                                                @error('new_password')
                                                {!! displayError($message) !!}
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-sm-4">
                                                <div class="form-group">
                                                    <input name="confirm_password" type="password"
                                                           placeholder="Confirm Password"
                                                           class="form-control">
                                                </div>
                                                @error('confirm_password')
                                                {!! displayError($message) !!}
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-sm-12 text-right">
                                                <button class="btn btn-theme btn-upa" type="submit"> Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <!--end main contain of page-->

            </div>
        </div>
    </section>
@endsection

@push('js') @endpush
