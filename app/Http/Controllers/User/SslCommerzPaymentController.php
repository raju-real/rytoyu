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
                    $query->where('payment_status','unpaid');
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
        //dd('fail',$request->all());
        $tran_id = $request->input('tran_id');
        $invoice = $request->input('value_a');
        if ($request->input('status') === "FAILED") {
            Transaction::where('transaction_id', $tran_id)
                ->update(['status' => 'FAILED', 'message' => $request->input('error')]);
        }

        $message = "Invalid Transaction";
        $transaction = Transaction::where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'transaction_amount')->first();

        if ($transaction->status === 'FAILED') {
            Transaction::where('transaction_id', $tran_id)
                ->update(['status' => 'FAILED']);
            $message = "Transaction Failed";
            Order::where('invoice', $invoice)->update(['payment_status' => 2]);
            Alert::error('Transaction Failed');
            return redirect()->route('user.order-history')
                ->with('message', $message);
        } else if ($transaction->status === 'SUCCESS') {
            Alert::info('Transaction is already Successful');
            return redirect()->route('user.order-history')
                ->with('message', $message);
        } else {
            $message = "Transaction Invalid";
            return redirect()->route('user.order-history')
                ->with('message', $message);
        }
    }

    public function cancel(Request $request)
    {
        //dd('cancel',$request->all());
        $tran_id = $request->input('tran_id');
        $invoice = $request->input('value_a');
        if ($request->input('status') === "CANCELLED") {
            Transaction::where('transaction_id', $tran_id)
                ->update(['status' => 'CANCELLED', 'message' => $request->input('error')]);
        }

        $message = "Invalid Transaction";
        $transaction = Transaction::where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'transaction_amount')->first();

        if ($transaction->status === 'CANCELLED') {
            $message = "Transaction Cancelled";
            Order::where('invoice', $invoice)->update(['payment_status' => 3]);
            Alert::error('Transaction Cancelled');
            return redirect()->route('user.order-history')
                ->with('message', $message);
        } else if ($transaction->status === "SUCCESS") {
            Alert::info('Transaction is already Successful');
            return redirect()->route('user.order-history')
                ->with('message', $message);
        } else {
            $message = "Transaction Invalid";
            return redirect()->route('user.order-history')
                ->with('message', $message);
        }
    }

    public function ipn(Request $request)
    {
        //dd('ipn',$request->all());
        #Received all the payement information from the gateway
        $message = "Unknown";
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $transaction = Transaction::where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'transaction_amount')->first();

            if ($transaction->status === 'PENDING') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $transaction->transaction_amount, $transaction->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    Transaction::where('transaction_id', $tran_id)
                        ->update(['status' => 'SUCCESS']);

                    $message =  "Transaction is successfully Completed";
                    return redirect()->route('user.order-history')
                        ->with('message', $message);
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    Transaction::where('transaction_id', $tran_id)
                        ->update(['status' => 'FAILED']);

                    $message =  "Transaction Fail";
                    return redirect()->route('user.order-history')
                        ->with('message', $message);
                }
            } else if ($transaction->status === "SUCCESS") {

                #That means Order status already updated. No need to udate database.

                $message =  "Transaction is already successfully Completed";
                return redirect()->route('user.order-history')
                    ->with('message', $message);
            } else {
                #That means something wrong happened. You can redirect customer to your product page.
                $message =  "Invalid Transaction";
                return redirect()->route('user.order-history')
                    ->with('message', $message);
            }
        } else {
            $message =  "Invalid Data";
            return redirect()->route('user.order-history')
                ->with('message', $message);
        }
    }
}
