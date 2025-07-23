@extends('user.layouts.app')
@section('title','Privacy Policy')

@section('content')
    <!-- BREADCRUMBS -->
    <section class="page-section breadcrumbs">
        <div class="container">
            <div class="page-header">
                <h1>Privacy Policy</h1>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Privacy Policy</li>
            </ul>
        </div>
    </section>
    <!-- /BREADCRUMBS -->
    <!-- PAGE -->
    <section class="page-section color">
        <div class="container">
            <section class="login-regis-area">
                <div class="login-regis-area-inner">
                    {!! siteSettings()['privacy_policy'] ?? '' !!}
                </div>
            </section>
        </div>
    </section>
    <!-- /PAGE -->
    </div>
@endsection

