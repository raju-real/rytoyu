@extends('user.layouts.app')
@section('title','About Us')

@section('content')
    <!-- BREADCRUMBS -->
    <section class="page-section breadcrumbs">
        <div class="container">
            <div class="page-header">
                <h1>About Us</h1>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">About Us</li>
            </ul>
        </div>
    </section>
    <!-- /BREADCRUMBS -->
    <!-- PAGE -->
    <section class="page-section color">
        <div class="container">
            <section class="login-regis-area">
                <div class="login-regis-area-inner">
                    {!! siteSettings()['about_us'] ?? '' !!}
                </div>
            </section>
        </div>
    </section>
    <!-- /PAGE -->
    </div>
@endsection

