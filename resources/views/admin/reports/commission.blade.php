@extends('admin.layouts.app')
@section('title', 'Commission Report')
@push('css')
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Commission & Payout Report</h4>
            </div>
        </div>
    </div>

    <!-- Accordion for Search -->
    <div class="row">
        <div class="col-12">
            <div class="accordion mb-3" id="accordionSearch">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSearch">
                        <button class="accordion-button {{ request()->query() ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseSearch"
                            aria-expanded="{{ request()->query() ? 'true' : 'false' }}" aria-controls="collapseSearch">
                            Search Filters
                        </button>
                    </h2>
                    <div id="collapseSearch" class="accordion-collapse collapse {{ request()->query() ? 'show' : '' }}"
                        aria-labelledby="headingSearch" data-bs-parent="#accordionSearch">
                        <div class="accordion-body">
                            <form action="{{ route('admin.reports.commission') }}" method="GET">
                                <div class="row align-items-end">
                                    <div class="col-md-5 pb-4">
                                        <div class="form-group">
                                            <label class="form-label">Start Date:</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ request('start_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-5 pb-4">
                                        <div class="form-group">
                                            <label class="form-label">End Date:</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ request('end_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-0 mb-4">
                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="text-white">Admin Commission</h5>
                    <h3>৳ {{ number_format($totalAdminCommission, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h5 class="text-white">Total Seller Payouts</h5>
                    <h3>৳ {{ number_format($totalSellerPayouts, 2) }}</h3>
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
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Order Number</th>
                                    <th>Seller</th>
                                    <th>Order Total</th>
                                    <th>Admin Comm.</th>
                                    <th>Seller Amt.</th>
                                    <th>Pay To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $key => $log)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $log->created_at->format('d M Y') }}</td>
                                        <td>#{{ $log->order_number }}</td>
                                        <td>
                                            @if ($log->seller)
                                                {{ $log->seller->shop->shop_name ?? $log->seller->name }}<br>
                                                <small>{{ $log->seller->mobile }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>৳ {{ number_format($log->order_amount, 2) }}</td>
                                        <td class="text-success fw-bold">+ ৳ {{ number_format($log->total_commission, 2) }}
                                        </td>
                                        <td class="text-primary fw-bold">৳ {{ number_format($log->seller_amount, 2) }}</td>
                                        <td>
                                            @if ($log->pay_to == 'seller')
                                                <span class="badge bg-info text-white">Seller</span>
                                            @else
                                                <span class="badge bg-dark">Merchant / System</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <x-no-data-found></x-no-data-found>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {!! $logs->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
