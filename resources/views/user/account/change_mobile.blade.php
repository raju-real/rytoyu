@extends('user.layouts.app')
@section('title','Change Mobile')
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
                        <div class="block-title alt"><i class="fa fa-angle-down"></i> Change Your Mobile</div>
                        <div class="details-box">
                            @if(Session::has('message'))
                                <p class="alert alert-info">{{ Session::get('message') }}</p>
                            @endif
                                <form class="form-delivery" action="{{ route("update-mobile") }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="all-form">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-4">
                                                <div class="form-group">
                                                    <input name="mobile" type="text"
                                                           placeholder="New Mobile"
                                                           class="form-control" value="{{ old('mobile') ?? '' }}">
                                                </div>
                                                @error('mobile')
                                                {!! displayError($message) !!}
                                                @enderror
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
