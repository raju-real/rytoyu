<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Payment\BkashService;
use Illuminate\Validation\Rule;

class BkashPaymentController extends Controller
{
    private $bkashService;

    public function __construct(BkashService $bkashService)
    {
        $this->bkashService = $bkashService;
    }

    public function index(Request $request)
    {
        $this->validate($request, [
            'unique_id' => [
                'required',
                Rule::exists('orders', 'unique_id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                })
            ],
        ]);

        try {
            return $this->bkashService->index($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function success(Request $request) {}
    public function fail(Request $request) {}
    public function cancel(Request $request) {}
    public function ipn(Request $request) {}
}
