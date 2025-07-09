@extends('user.layouts.app')
@section('title','Faq')

@section('content')
    <!-- BREADCRUMBS -->
    <section class="page-section breadcrumbs">
        <div class="container">
            <div class="page-header">
                <h1>Faq</h1>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Faq</li>
            </ul>
        </div>
    </section>
    <!-- /BREADCRUMBS -->
    <!-- PAGE -->
    <section class="page-section color">
        <div class="container">
            @foreach(\App\Models\Faq::latest()->get() as $key => $faq)
                <div class="panel-group accordion accordion-custom" id="accordion" role="tablist"
                     aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading{{ $key }}">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key }}"
                                   aria-expanded="true"
                                   aria-controls="collapse{{ $key }}">
                                    <span class="dot"></span> {{ $faq->question ?? '' }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{ $key }}" class="panel-collapse collapse {{ $loop->first ? 'in' : '' }}"
                             role="tabpanel" aria-labelledby="heading{{ $key }}">
                            <div class="panel-body">{{ $faq->answer ?? '' }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
        </div>
    </section>
    <!-- /PAGE -->
    </div>
@endsection

