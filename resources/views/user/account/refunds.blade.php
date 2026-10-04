@extends('user.layouts.master')
@section('title', 'My Refunds')
@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow">Home</a>
                    <span></span> My Account
                    <span></span> My Refunds
                </div>
            </div>
        </div>
        <section class="pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        @include('user.account.sidebar')
                    </div>
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h5 class="mb-0">Refund Requests</h5>
                            </div>
                            <div class="card-body">
                                @if (session('type') && session('message'))
                                    <div class="alert alert-{{ session('type') == 'error' ? 'danger' : 'success' }}">
                                        {{ session('message') }}
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Order</th>
                                                <th>Product</th>
                                                <th>Reason</th>
                                                <th>Admin Note</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($refunds as $refund)
                                                <tr>
                                                    <td>{{ $refund->created_at->format('d M Y') }}</td>
                                                    <td>#{{ $refund->order->order_number ?? 'N/A' }}</td>
                                                    <td>
                                                        <a
                                                            href="{{ route('product-details', $refund->orderProduct->product->slug ?? '') }}">
                                                            {{ $refund->orderProduct->product->name ?? 'N/A' }}
                                                        </a>
                                                        <br><small>Qty: {{ $refund->orderProduct->quantity ?? 1 }}</small>
                                                    </td>
                                                    <td>{{ \Illuminate\Support\Str::limit($refund->reason, 50) }}</td>
                                                    <td>{{ $refund->admin_note ?? '-' }}</td>
                                                    <td>
                                                        @if ($refund->status == 'pending')
                                                            <span
                                                                class="badge rounded-pill bg-warning text-dark">Pending</span>
                                                        @elseif($refund->status == 'approved')
                                                            <span
                                                                class="badge rounded-pill bg-info text-white">Approved</span>
                                                        @elseif($refund->status == 'completed')
                                                            <span class="badge rounded-pill bg-success">Completed</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-danger">Rejected</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No refund requests found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
