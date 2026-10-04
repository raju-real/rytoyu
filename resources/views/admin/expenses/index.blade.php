@extends('admin.layouts.app')
@section('title', 'Expense Management')
@push('css')
    <style>
        .stats-pill {
            border-radius: 12px;
            padding: 16px 20px;
        }

        .expense-amount {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--color-text-dark);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4><i class="bx bx-wallet"></i> Expense Management</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-soft-info" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="bx bx-category"></i> Manage Categories
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                        <i class="bx bx-plus"></i> Add Expense
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Card --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card stats-pill">
                <div class="d-flex align-items-center gap-3">
                    <div class="mini-stat-icon avatar-sm rounded-circle bg-danger" style="min-width:44px;">
                        <span class="avatar-title rounded-circle bg-danger"><i class="bx bx-money font-size-24"></i></span>
                    </div>
                    <div>
                        <p class="text-muted mb-1" style="font-size:12px;">Total Expenses (filtered)</p>
                        <div class="expense-amount">৳ {{ number_format($totalSum, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <form action="{{ route('admin.expenses.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select form-select-sm">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">From</label>
                    <input type="date" name="from" class="form-control form-control-sm" value="{{ $from }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To</label>
                    <input type="date" name="to" class="form-control form-control-sm" value="{{ $to }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bx bx-filter-alt"></i> Filter</button>
                    <a href="{{ route('admin.expenses.index') }}" class="btn btn-soft-danger btn-sm"><i class="bx bx-x"></i>
                        Clear</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Expense Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Attachment</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $key => $expense)
                            <tr>
                                <td class="td-center">{{ $expenses->firstItem() + $key }}</td>
                                <td class="td-truncate" {!! tooltip($expense->title) !!}>{{ textLimit($expense->title) }}</td>
                                <td>
                                    @if ($expense->category)
                                        <span class="expense-cat-pill"
                                            style="background:{{ $expense->category->color }}22;color:{{ $expense->category->color }};">
                                            {{ $expense->category->name }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="fw-bold text-danger">৳ {{ number_format($expense->amount, 2) }}</td>
                                <td class="td-center">{{ $expense->expense_date->format('M d, Y') }}</td>
                                <td class="td-center">
                                    @if ($expense->attachment)
                                        <a href="{{ asset('storage/' . $expense->attachment) }}" target="_blank"
                                            class="btn btn-sm btn-soft-info py-1 px-2" {!! tooltip('View Attachment') !!}>
                                            <i class="bx bx-paperclip"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="td-center">
                                    <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger"
                                            onclick="return confirm('Delete expense?')" {!! tooltip('Delete') !!}>
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bx bx-inbox" style="font-size:2rem;"></i>
                                    <p class="mt-2">No expenses recorded yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $expenses->links() }}
        </div>
    </div>

    {{-- Add Expense Modal --}}
    <div class="modal fade" id="addExpenseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-plus-circle me-2"></i>Record Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.expenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required
                                placeholder="Expense title">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Amount (৳) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="amount" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="expense_date" class="form-control" required
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="expense_category_id" class="form-select">
                                <option value="">Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Attachment (optional)</label>
                            <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-soft-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Category Manager Modal --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-category me-2"></i>Expense Categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.expenses.categories.store') }}" method="POST"
                        class="d-flex gap-2 mb-3">
                        @csrf
                        <input type="text" name="name" class="form-control" placeholder="Category name" required>
                        <input type="color" name="color" class="form-control" style="width:60px;padding:4px;"
                            value="#4361ee">
                        <button type="submit" class="btn btn-primary" style="white-space:nowrap;">
                            <i class="bx bx-plus"></i> Add
                        </button>
                    </form>
                    <div class="list-group">
                        @foreach ($categories as $cat)
                            <div class="list-group-item d-flex align-items-center justify-content-between py-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        style="width:14px;height:14px;border-radius:50%;background:{{ $cat->color }};display:inline-block;"></span>
                                    <span>{{ $cat->name }}</span>
                                </div>
                                <form action="{{ route('admin.expenses.categories.destroy', $cat) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger py-1 px-2"
                                        onclick="return confirm('Delete category?')" {!! tooltip('Delete category') !!}>
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                        @if ($categories->isEmpty())
                            <p class="text-muted text-center py-3">No categories yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
