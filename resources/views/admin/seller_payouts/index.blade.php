@extends('admin.layouts.master')
@section('title', 'My Payouts')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Alert Messages -->
            @if (session('type') && session('message'))
                <div class="alert alert-{{ session('type') == 'error' ? 'danger' : 'success' }} alert-dismissible fade show"
                    role="alert">
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Request a Payout <span class="badge badge-info ml-2">Available Balance: ৳
                            {{ number_format($seller->balance, 2) }}</span></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('request-payout') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="amount">Amount to Withdraw (৳)</label>
                                <input type="number" step="0.01" min="100" max="{{ $seller->balance }}"
                                    name="amount" id="amount" class="form-control" required placeholder="Minimum 100">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="transaction_method">Payout Method</label>
                                <select name="transaction_method" id="transaction_method" class="form-control" required>
                                    <option value="">Select Method</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="mobile_banking">Mobile Banking (bKash/Rocket/Nagad)</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="instructions">Account Details / Instructions</label>
                                <input type="text" name="instructions" id="instructions" class="form-control"
                                    placeholder="e.g. bKash Personal 01XXXXXXXXX" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" {{ $seller->balance < 100 ? 'disabled' : '' }}>Submit
                            Request</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Payout History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Requested Amount</th>
                                    <th>Method</th>
                                    <th>Instructions</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payouts as $key => $payout)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $payout->created_at->format('d M, Y h:i A') }}</td>
                                        <td>৳ {{ number_format($payout->amount, 2) }}</td>
                                        <td>{{ Str::ucfirst(str_replace('_', ' ', $payout->transaction_method)) }}</td>
                                        <td>{{ $payout->instructions ?? 'N/A' }}</td>
                                        <td>
                                            @if ($payout->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($payout->status == 'approved')
                                                <span class="badge badge-success">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
