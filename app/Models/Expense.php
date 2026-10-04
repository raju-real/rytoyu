<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['admin_id', 'expense_category_id', 'title', 'description', 'amount', 'expense_date', 'attachment'];

    protected $casts = ['expense_date' => 'date', 'amount' => 'decimal:2'];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
