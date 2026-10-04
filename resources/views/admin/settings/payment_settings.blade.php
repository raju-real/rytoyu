@extends('admin.layouts.app')
@section('title','Payment Settings')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Payment Settings</h4>
            </div>
        </div>
    </div>

    @php
        $settings = paymentSettings();
    @endphp

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#sslcommerz" role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-money-check-alt"></i></span>
                                <span class="d-none d-sm-block">SSLCommerz</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#bkash" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-mobile-alt"></i></span>
                                <span class="d-none d-sm-block">bKash</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#rocket" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-rocket"></i></span>
                                <span class="d-none d-sm-block">Rocket</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#nagad" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-coins"></i></span>
                                <span class="d-none d-sm-block">Nagad</span>
                            </a>
                        </li>
                    </ul>

                    <form action="{{ route('admin.update-payment-settings') }}" method="POST" id="prevent-form">
                        @csrf
                        @method('PUT')
                        
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            
                            <!-- SSLCommerz Tab -->
                            <div class="tab-pane active" id="sslcommerz" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                            <input type="hidden" name="sslcommerz_status" value="0">
                                            <input class="form-check-input" type="checkbox" id="sslcommerz_status" name="sslcommerz_status" value="1" {{ ($settings['sslcommerz_status'] ?? '0') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sslcommerz_status">Enable SSLCommerz API</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Store ID</label>
                                        <input type="text" name="sslcommerz_store_id" value="{{ old('sslcommerz_store_id') ?? $settings['sslcommerz_store_id'] ?? '' }}" class="form-control" placeholder="Store ID">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Store Password</label>
                                        <input type="password" name="sslcommerz_store_password" value="{{ old('sslcommerz_store_password') ?? $settings['sslcommerz_store_password'] ?? '' }}" class="form-control" placeholder="Store Password">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mode</label>
                                        <select name="sslcommerz_mode" class="form-control">
                                            <option value="sandbox" {{ ($settings['sslcommerz_mode'] ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox Mode</option>
                                            <option value="live" {{ ($settings['sslcommerz_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live Mode</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- bKash Tab -->
                            <div class="tab-pane" id="bkash" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                            <input type="hidden" name="bkash_status" value="0">
                                            <input class="form-check-input" type="checkbox" id="bkash_status" name="bkash_status" value="1" {{ ($settings['bkash_status'] ?? '0') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bkash_status">Enable bKash API</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">App Key</label>
                                        <input type="text" name="bkash_app_key" value="{{ old('bkash_app_key') ?? $settings['bkash_app_key'] ?? '' }}" class="form-control" placeholder="App Key">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">App Secret</label>
                                        <input type="password" name="bkash_app_secret" value="{{ old('bkash_app_secret') ?? $settings['bkash_app_secret'] ?? '' }}" class="form-control" placeholder="App Secret">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="bkash_username" value="{{ old('bkash_username') ?? $settings['bkash_username'] ?? '' }}" class="form-control" placeholder="Username">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="bkash_password" value="{{ old('bkash_password') ?? $settings['bkash_password'] ?? '' }}" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mode</label>
                                        <select name="bkash_mode" class="form-control">
                                            <option value="sandbox" {{ ($settings['bkash_mode'] ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox Mode</option>
                                            <option value="live" {{ ($settings['bkash_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live Mode</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Rocket Tab -->
                            <div class="tab-pane" id="rocket" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                            <input type="hidden" name="rocket_status" value="0">
                                            <input class="form-check-input" type="checkbox" id="rocket_status" name="rocket_status" value="1" {{ ($settings['rocket_status'] ?? '0') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rocket_status">Enable Rocket API</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Merchant Account / ID</label>
                                        <input type="text" name="rocket_merchant_account" value="{{ old('rocket_merchant_account') ?? $settings['rocket_merchant_account'] ?? '' }}" class="form-control" placeholder="Merchant Account">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mode</label>
                                        <select name="rocket_mode" class="form-control">
                                            <option value="sandbox" {{ ($settings['rocket_mode'] ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox Mode</option>
                                            <option value="live" {{ ($settings['rocket_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live Mode</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Nagad Tab -->
                            <div class="tab-pane" id="nagad" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                            <input type="hidden" name="nagad_status" value="0">
                                            <input class="form-check-input" type="checkbox" id="nagad_status" name="nagad_status" value="1" {{ ($settings['nagad_status'] ?? '0') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="nagad_status">Enable Nagad API</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Merchant ID</label>
                                        <input type="text" name="nagad_merchant_id" value="{{ old('nagad_merchant_id') ?? $settings['nagad_merchant_id'] ?? '' }}" class="form-control" placeholder="Merchant ID">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Merchant Number</label>
                                        <input type="text" name="nagad_merchant_number" value="{{ old('nagad_merchant_number') ?? $settings['nagad_merchant_number'] ?? '' }}" class="form-control" placeholder="Merchant Number">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Public Key</label>
                                        <textarea name="nagad_public_key" class="form-control" rows="3" placeholder="Public Key">{{ old('nagad_public_key') ?? $settings['nagad_public_key'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Private Key</label>
                                        <textarea name="nagad_private_key" class="form-control" rows="3" placeholder="Private Key">{{ old('nagad_private_key') ?? $settings['nagad_private_key'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mode</label>
                                        <select name="nagad_mode" class="form-control">
                                            <option value="sandbox" {{ ($settings['nagad_mode'] ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox Mode</option>
                                            <option value="live" {{ ($settings['nagad_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live Mode</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bx bx-check-circle me-1"></i> Update Payment Settings
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
