<?php

namespace App\Models\Scopes;

use App\Models\SellerOrderLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class SellerOrderScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (authAdminType() === 'seller') {
            $builder->whereIn('id',
                SellerOrderLog::select('order_id')
                    ->where('seller_id', Auth::id())
            );
        }
    }
}
