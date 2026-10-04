<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $adminId    = authAdmin()->id;
        $categoryId = $request->get('category_id');
        $from       = $request->get('from');
        $to         = $request->get('to');

        $query = Expense::where('admin_id', $adminId)->with('category')->latest('expense_date');

        if ($categoryId) {
            $query->where('expense_category_id', $categoryId);
        }
        if ($from) {
            $query->whereDate('expense_date', '>=', $from);
        }
        if ($to) {
            $query->whereDate('expense_date', '<=', $to);
        }

        $expenses   = $query->paginate(20);
        $categories = ExpenseCategory::orderBy('name')->get();
        $totalSum   = $query->sum('amount');

        return view('admin.expenses.index', compact('expenses', 'categories', 'totalSum', 'categoryId', 'from', 'to'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string',
            'amount'              => 'required|numeric|min:0',
            'expense_date'        => 'required|date',
            'expense_category_id' => 'nullable|exists:expense_categories,id',
            'attachment'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data['admin_id'] = authAdmin()->id;

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')
                ->store('expenses', 'public');
        }

        Expense::create($data);
        return back()->with('success', 'Expense recorded.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->attachment) {
            Storage::disk('public')->delete($expense->attachment);
        }
        $expense->delete();
        return back()->with('success', 'Expense deleted.');
    }

    // ── Category CRUD ────────────────────────────────────────
    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100', 'color' => 'nullable|string']);
        ExpenseCategory::create($request->only('name', 'color'));
        return back()->with('success', 'Category created.');
    }

    public function destroyCategory(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
        return back()->with('success', 'Category deleted.');
    }
}
