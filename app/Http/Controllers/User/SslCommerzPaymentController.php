<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Services\Payment\SslCommerz;

class SslCommerzPaymentController extends Controller
{
    protected SslCommerz $sslCommerz;

    public function __construct(SslCommerz $sslCommerz)
    {
        $this->sslCommerz = $sslCommerz;
    }

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        $this->validate($request, [
            'unique_id' => [
                'required',
                Rule::exists('orders', 'unique_id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                    // $query->where('payment_status','unpaid');
                })
            ],
        ]);

        try {
            return $this->sslCommerz->index($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        try {
            return $this->sslCommerz->success($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function fail(Request $request)
    {
        try {
            return $this->sslCommerz->fail($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function cancel(Request $request)
    {
        try {
            return $this->sslCommerz->cancel($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ipn(Request $request)
    {
        try {
            return $this->sslCommerz->ipn($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
