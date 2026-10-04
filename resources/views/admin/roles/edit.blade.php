@extends('admin.layouts.app')
@section('title', 'Role Edit')
@push('css')
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Role Edit: {{ $role->name }}</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline-primary">
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
                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" id="prevent-form">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Role Name {!! starSign() !!}</label>
                                    <input type="text" name="name" id="name" required
                                        value="{{ old('name', $role->name) }}" class="form-control {{ hasError('name') }}"
                                        placeholder="Role Name">
                                    @error('name')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Permissions {!! starSign() !!}</label>
                                    @php
                                        $currentPerms = is_array($role->permissions) ? $role->permissions : [];
                                        $oldPerms = old('permissions', $currentPerms);
                                    @endphp
                                    <div class="row">
                                        @foreach ($permissions as $key => $label)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check custom-checkbox">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="perm_{{ $key }}" name="permissions[]"
                                                        value="{{ $key }}"
                                                        {{ is_array($oldPerms) && in_array($key, $oldPerms) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="perm_{{ $key }}">{{ $label }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('permissions')
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
