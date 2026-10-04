@extends('admin.layouts.app')
@section('title', 'Manage Refund Requests')
@push('css')
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">User Refund Requests</h4>
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
                                    <th>User</th>
                                    <th>Order Info</th>
                                    <th>Product</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($refunds as $key => $refund)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $refund->created_at->format('d M Y h:i A') }}</td>
                                        <td>
                                            {{ $refund->user->name ?? 'N/A' }}<br>
                                            <small>{{ $refund->user->mobile ?? '' }}</small>
                                        </td>
                                        <td>
                                            Order: #{{ $refund->order->order_number ?? 'N/A' }}<br>
                                            <small>৳ {{ number_format($refund->orderProduct->total_price ?? 0, 2) }}</small>
                                        </td>
                                        <td>{{ Str::limit($refund->orderProduct->product->name ?? 'N/A', 30) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#reasonModal{{ $refund->id }}">View</button>

                                            <!-- Reason Modal -->
                                            <div class="modal fade" id="reasonModal{{ $refund->id }}" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Refund Reason</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-wrap">
                                                            <p><strong>Reason:</strong></p>
                                                            <p>{{ $refund->reason }}</p>
                                                            @if ($refund->admin_note)
                                                                <hr>
                                                                <p><strong>Admin Note:</strong></p>
                                                                <p>{{ $refund->admin_note }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($refund->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($refund->status == 'approved')
                                                <span class="badge bg-info">Approved</span>
                                            @elseif($refund->status == 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($refund->status == 'pending' || $refund->status == 'approved')
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#processModal{{ $refund->id }}">Process</button>

                                                <!-- Process Modal -->
                                                <div class="modal fade" id="processModal{{ $refund->id }}" tabindex="-1"
                                                    role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form action="{{ route('process-refund', $refund->id) }}"
                                                            method="POST" id="prevent-form-{{ $refund->id }}">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Process Refund Request</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Update Status
                                                                            {!! starSign() !!}</label>
                                                                        <select name="status"
                                                                            class="form-select select2-search-disable"
                                                                            required>
                                                                            <option value="pending"
                                                                                {{ $refund->status == 'pending' ? 'selected' : '' }}>
                                                                                Pending</option>
                                                                            <option value="approved"
                                                                                {{ $refund->status == 'approved' ? 'selected' : '' }}>
                                                                                Approved (Ready)</option>
                                                                            <option value="completed"
                                                                                {{ $refund->status == 'completed' ? 'selected' : '' }}>
                                                                                Completed (Refunded)</option>
                                                                            <option value="rejected"
                                                                                {{ $refund->status == 'rejected' ? 'selected' : '' }}>
                                                                                Rejected</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Admin Note</label>
                                                                        <textarea name="admin_note" class="form-control" rows="3" placeholder="Notes for the customer...">{{ $refund->admin_note }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        Changes</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
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
