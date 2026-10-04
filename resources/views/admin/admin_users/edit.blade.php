@extends('admin.layouts.app')
@section('title', 'Admin User Edit')
@push('css')
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Admin User Edit: {{ $admin->name }}</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.admin-users.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-arrow-circle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.admin-users.update', $admin->id) }}" method="POST" id="prevent-form">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Full Name {!! starSign() !!}</label>
                                    <input class="form-control {{ hasError('name') }}" type="text" name="name"
                                        id="name" required value="{{ old('name', $admin->name) }}"
                                        placeholder="Full Name">
                                    @error('name')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email Address {!! starSign() !!}</label>
                                    <input class="form-control {{ hasError('email') }}" type="email" name="email"
                                        id="email" required value="{{ old('email', $admin->email) }}"
                                        placeholder="Email Address">
                                    @error('email')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Password (Leave blank to keep current)</label>
                                    <input class="form-control {{ hasError('password') }}" type="password" name="password"
                                        id="password" placeholder="Password">
                                    @error('password')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Assign Role {!! starSign() !!}</label>
                                    <select class="form-select select2-search-disable {{ hasError('role_id') }}"
                                        name="role_id" id="role_id" required>
                                        <option value="">Select a Role</option>
                                        <option value="administrator"
                                            {{ old('role_id', $admin->type == 'administrator' ? 'administrator' : $admin->role_id) == 'administrator' ? 'selected' : '' }}>
                                            Super Administrator</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id', $admin->role_id) == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <x-submit-button></x-submit-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
