<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Payment\RocketService;
use Illuminate\Validation\Rule;

class RocketPaymentController extends Controller
{
    private $rocketService;

    public function __construct(RocketService $rocketService)
    {
        $this->rocketService = $rocketService;
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
            return $this->rocketService->index($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function success(Request $request) {}
    public function fail(Request $request) {}
    public function cancel(Request $request) {}
    public function ipn(Request $request) {}
}
