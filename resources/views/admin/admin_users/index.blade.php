@extends('admin.layouts.app')
@section('title', 'Manage Admin Users')
@push('css')
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Manage Admin Users</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.admin-users.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus-circle"></i> Add New
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if (session('type') && session('message'))
        <div class="alert alert-{{ session('type') == 'error' ? 'danger' : 'success' }} alert-dismissible fade show"
            role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type / Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($admins as $key => $admin)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td {!! tooltip($admin->name) !!}>{{ textLimit($admin->name) }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>
                                            @if ($admin->type === 'administrator')
                                                <span class="badge bg-success">Administrator</span>
                                            @else
                                                <span
                                                    class="badge bg-info">{{ $admin->role->name ?? 'No Role Assigned' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                href="{{ route('admin.admin-users.edit', $admin->id) }}"
                                                class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i></a>
                                            @if (
                                                $admin->id !== Auth::guard('admin')->id() &&
                                                    ($admin->type !== 'administrator' || \App\Models\Admin::where('type', 'administrator')->count() > 1))
                                                <form action="{{ route('admin.admin-users.destroy', $admin->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Delete" class="btn btn-sm btn-soft-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <x-no-data-found></x-no-data-found>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
