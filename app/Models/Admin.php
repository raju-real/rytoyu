<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $table = "admins";
    protected string $guard = 'admin';
    protected $fillable = ['name', 'email', 'mobile', 'password', 'image', 'status', 'last_login_at', 'last_logout_at'];

    public function pushSubscriptions()
    {
        return $this->morphMany(\NotificationChannels\WebPush\PushSubscription::class, 'subscribable');
        // OR if using separate table:
        // return $this->hasMany(PushSubscription::class, 'admin_id');
    }

    public function scopeAdmin($query)
    {
        return $query->where('type', 'admin');
    }

    public function scopeSeller($query)
    {
        return $query->where('type', 'seller');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopePending($query)
    {
        return $query->where('request_status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('request_status', 'approved');
    }

    public static function getCode()
    {
        // Fetch the latest code, considering soft deletes
        $latestCode = Admin::whereNotNull('code')->withTrashed()->latest('id')->value('code');
        // If no code exists, start from 101
        $newCode = $latestCode ? str_pad($latestCode + 1, 3, "0", STR_PAD_LEFT) : '101';
        return $newCode;
    }

    public function shop() {
        return $this->hasOne(SellerShop::class,'seller_id','id');
    }
}
