@extends('user.layouts.app')
@section('title','Terms and Conditions')

@section('content')
    <!-- BREADCRUMBS -->
    <section class="page-section breadcrumbs">
        <div class="container">
            <div class="page-header">
                <h1>Terms and Conditions</h1>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Terms and Conditions</li>
            </ul>
        </div>
    </section>
    <!-- /BREADCRUMBS -->
    <!-- PAGE -->
    <section class="page-section color">
        <div class="container">
            <section class="login-regis-area">
                <div class="login-regis-area-inner">
                    {!! siteSettings()['terms_conditions'] ?? '' !!}
                </div>
            </section>
        </div>
    </section>
    <!-- /PAGE -->
    </div>
@endsection

