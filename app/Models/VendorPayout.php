<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPayout extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function seller()
    {
        return $this->belongsTo(Admin::class, 'seller_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
