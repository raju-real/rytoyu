<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\View\Factory;

class InventoryController extends Controller
{
    public function productStockStatus (): Factory|View|Application
    {
        return view('admin.inventory.product_stock_status');
    }
}
