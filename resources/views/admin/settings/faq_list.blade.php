@extends('admin.layouts.app')
@section('title','Faq List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Faq List</h4>

                <div class="page-title-right">
                    <a href="{{ route('admin.faqs.create') }}" class="btn btn-sm btn-primary">
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
                    <div class="">
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                            <tr>
                                <th>Sl.no</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($faqs as $faq)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $faq->question ?? '' }}</td>
                                    <td>{{ $faq->answer ?? '' }}</td>
                                    <td class="text-nowrap">
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.faqs.edit',$faq->id) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i></a>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                           class="btn btn-sm btn-soft-danger delete-data"
                                           data-id="{{ 'delete-faq-'.$faq->id }}"
                                           href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-faq-{{ $faq->id }}"
                                              action="{{ route('admin.faqs.destroy',$faq->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
                    {!! $faqs->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js') @endpush
