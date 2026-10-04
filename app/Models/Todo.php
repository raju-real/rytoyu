<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'title', 'description', 'priority', 'status', 'due_date'];

    protected $casts = ['due_date' => 'date'];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    public function scopeDone($query)
    {
        return $query->where('status', 'done');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
