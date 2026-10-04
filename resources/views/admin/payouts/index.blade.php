@extends('admin.layouts.app')
@section('title', 'Manage Vendor Payouts')
@push('css')
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Vendor Payout Requests</h4>
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
                                    <th>Date</th>
                                    <th>Vendor</th>
                                    <th>Requested Amount</th>
                                    <th>Method</th>
                                    <th>Instructions</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payouts as $key => $payout)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $payout->created_at->format('d M, Y h:i A') }}</td>
                                        <td>{{ $payout->seller ? $payout->seller->name : 'N/A' }}</td>
                                        <td>৳ {{ number_format($payout->amount, 2) }}</td>
                                        <td>{{ Str::ucfirst(str_replace('_', ' ', $payout->transaction_method)) }}</td>
                                        <td>{{ $payout->instructions ?? 'N/A' }}</td>
                                        <td>
                                            @if ($payout->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($payout->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payout->status == 'pending')
                                                <form action="{{ route('process-payout', $payout->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Approve this payout? It will deduct balance from the seller.')"
                                                    id="prevent-form-approve-{{ $payout->id }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Approve" class="btn btn-sm btn-soft-success">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('process-payout', $payout->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to reject this payout?')"
                                                    id="prevent-form-reject-{{ $payout->id }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Reject" class="btn btn-sm btn-soft-danger">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted">Processed</span>
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
