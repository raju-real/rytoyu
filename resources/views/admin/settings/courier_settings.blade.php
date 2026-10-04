@extends('admin.layouts.app')
@section('title', 'Courier Settings')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18"><i class="bx bx-cog"></i> Courier Settings</h4>
            </div>
        </div>
    </div>

    @php
        $settings = courierSettings();
    @endphp

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#steadfast" role="tab"
                                aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-truck"></i></span>
                                <span class="d-none d-sm-block">Steadfast</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#pathao" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-motorcycle"></i></span>
                                <span class="d-none d-sm-block">Pathao</span>
                            </a>
                        </li>
                    </ul>

                    <form action="{{ route('admin.update-courier-settings') }}" method="POST" id="prevent-form">
                        @csrf
                        @method('PUT')

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">

                            <!-- Steadfast Tab -->
                            <div class="tab-pane active" id="steadfast" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                            <input type="hidden" name="steadfast_status" value="0">
                                            <input class="form-check-input" type="checkbox" id="steadfast_status"
                                                name="steadfast_status" value="1"
                                                {{ ($settings['steadfast_status'] ?? '0') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="steadfast_status">Enable Steadfast Courier
                                                API</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">API Key</label>
                                        <input type="text" name="steadfast_api_key"
                                            value="{{ old('steadfast_api_key') ?? ($settings['steadfast_api_key'] ?? '') }}"
                                            class="form-control" placeholder="API Key">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Secret Key</label>
                                        <input type="text" name="steadfast_secret_key"
                                            value="{{ old('steadfast_secret_key') ?? ($settings['steadfast_secret_key'] ?? '') }}"
                                            class="form-control" placeholder="Secret Key">
                                    </div>
                                </div>
                            </div>

                            <!-- Pathao Tab -->
                            <div class="tab-pane" id="pathao" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                            <input type="hidden" name="pathao_status" value="0">
                                            <input class="form-check-input" type="checkbox" id="pathao_status"
                                                name="pathao_status" value="1"
                                                {{ ($settings['pathao_status'] ?? '0') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pathao_status">Enable Pathao Courier
                                                API</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Client ID</label>
                                        <input type="text" name="pathao_client_id"
                                            value="{{ old('pathao_client_id') ?? ($settings['pathao_client_id'] ?? '') }}"
                                            class="form-control" placeholder="Client ID">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Client Secret</label>
                                        <input type="password" name="pathao_client_secret"
                                            value="{{ old('pathao_client_secret') ?? ($settings['pathao_client_secret'] ?? '') }}"
                                            class="form-control" placeholder="Client Secret">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="pathao_username"
                                            value="{{ old('pathao_username') ?? ($settings['pathao_username'] ?? '') }}"
                                            class="form-control" placeholder="Username">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="pathao_password"
                                            value="{{ old('pathao_password') ?? ($settings['pathao_password'] ?? '') }}"
                                            class="form-control" placeholder="Password">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Store ID</label>
                                        <input type="text" name="pathao_store_id"
                                            value="{{ old('pathao_store_id') ?? ($settings['pathao_store_id'] ?? '') }}"
                                            class="form-control" placeholder="Store ID">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bx bx-check-circle me-1"></i> Update Courier Settings
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
