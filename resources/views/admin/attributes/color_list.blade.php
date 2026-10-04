@extends('admin.layouts.app')
@section('title','Color List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Color List</h4>

                <div class="page-title-right">
                    <a href="{{ route('admin.colors.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus-circle"></i> Add New
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                            <tr>
                                <th>Sl.no</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($colors as $color)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td {!! tooltip($color->name ?? '') !!}>{{ textLimit($color->name ?? '') }}</td>
                                    <td>
                                        <div class="color-box"
                                             style="{{ colorControl('background-color', $color->color_code) }};{{ colorControl('color', $color->color_code) }}">
                                            {{ $color->color_code ?? 'No Color' }}
                                        </div>
                                        {{ $color->color_code ?? 'No Color' }}
                                    </td>
                                    <td>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" href="{{ route('admin.colors.edit',$color->slug) }}"
                                           class="btn btn-sm btn-soft-success" ><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <x-no-data-found></x-no-data-found>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="d-flex justify-content-center">
                    {!! $colors->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js') @endpush
