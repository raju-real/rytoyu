@extends('admin.layouts.app')
@section('title','Announcement List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Announcement List</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.announcements.create') }}" class="btn btn-sm btn-primary">
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
                                <th>Title</th>
                                <th>Highlighted Title</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($announcements as $announcement)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $announcement->title ?? '' }}</td>
                                    <td><b>{{ $announcement->highlighted_title ?? '' }}</b></td>
                                    <td>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.announcements.edit',$announcement->id) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i></a>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                           class="btn btn-sm btn-soft-danger delete-data"
                                           data-id="{{ 'delete-announcement-'.$announcement->id }}"
                                           href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-announcement-{{ $announcement->id }}"
                                              action="{{ route('admin.announcements.destroy',$announcement->id) }}"
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
                    {!! $announcements->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js') @endpush
