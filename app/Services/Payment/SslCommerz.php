<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Auth;

/**
 * Class SslCommerz.
 */
class SslCommerz
{
    public function index($request)
    {
        $unique_id = $request->unique_id;
        $order = Order::whereUniqueId($unique_id)->first();
        $user = Auth::user();

        $post_data = array();
        $post_data['total_amount'] = $order->total_order_price;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = Str::upper(uniqid()); // tran_id must be unique
        //$post_data['tran_id'] = Transaction::generateTransactionId($order->order_number); // tran_id must be unique

        # Set Address
        $name = $order->customer_full_name ?? $user->full_name;
        $mobile = $order->mobile ?? $user->mobile;
        $email = $order->email ?? $user->email;
        $city_town = $order->city_town ?? $user->city_town;
        $post_code = $order->post_code ?? $user->zip_code;
        $address = $order->address ?? $user->delivery_address;


        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $name;
        $post_data['cus_email'] = $email;
        $post_data['cus_add1'] = $address;
        $post_data['cus_add2'] = $address;
        $post_data['cus_city'] = $city_town;
        $post_data['cus_state'] = $city_town;
        $post_data['cus_postcode'] = $post_code;
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $mobile;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $name;
        $post_data['ship_add1'] = $address;
        $post_data['ship_add2'] = $address;
        $post_data['ship_city'] = $city_town;
        $post_data['ship_state'] = $city_town;
        $post_data['ship_postcode'] = $post_code ?? "";
        $post_data['ship_phone'] = $mobile;
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $order->unique_id;
        $post_data['value_b'] = $order->order_number;
        $post_data['value_c'] = $order->invoice;
        $post_data['value_d'] = "ref004";
        $post_data['value_e'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $identify = [
            'order_id' => $order->id,
            'unique_id' => $order->unique_id,
            'user_id' => Auth::id()
        ];
        $data = [
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'unique_id' => $order->unique_id,
            'order_number' => $order->order_number,
            'invoice' => $order->invoice,
            'transaction_id' => $post_data['tran_id'],
            'transaction_time' => now(),
            'transaction_ip' => request()->ip(),
            'transaction_amount' => $post_data['total_amount'],
            'status' => 'PENDING',
            'name' => $name,
            'mobile' => $mobile,
            'city_town' => $city_town,
            'post_code' => $post_code,
            'address' => $address,
            'currency' => $post_data['currency'],
            'created_at' => now(),
            'updated_at' => now()
        ];
        Transaction::updateOrInsert($identify, $data);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success($request)
    {
        //dd('success',$request->all());

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();
        $transaction = Transaction::where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'transaction_amount')->firstOrFail();

        if (($request->input('status') === "VALID") and ($transaction->status === 'PENDING')) {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                Transaction::where('transaction_id', $tran_id)
                    ->update([
                        'gateway' => 'sslcommerz',
                        'status' => 'SUCCESS',
                        'val_id' => $request->input('val_id'),
                        'card_type' => $request->input('card_type'),
                        'store_amount' => $request->input('store_amount'),
                        'card_no' => $request->input('card_no'),
                        'bank_tran_id' => $request->input('bank_tran_id'),
                        'transaction_date' => $request->input('tran_date'),
                        'transaction_time' => $request->input('tran_date'),
                        'error' => $request->input('error'),
                        'currency' => $request->input('currency'),
                        'card_issuer' => $request->input('card_issuer'),
                        'card_brand' => $request->input('card_brand'),
                        'card_sub_brand' => $request->input('card_sub_brand'),
                        'card_issuer_country' => $request->input('card_issuer_country'),
                        'card_issuer_country_code' => $request->input('card_issuer_country_code'),
                        'store_id' => $request->input('store_id'),
                        'verify_sign' => $request->input('verify_sign'),
                        'verify_key' => $request->input('verify_key'),
                        'verify_sign_sha2' => $request->input('verify_sign_sha2'),
                        'currency_type' => $request->input('currency_type'),
                        'currency_amount' => $request->input('currency_amount'),
                        'currency_rate' => $request->input('currency_rate'),
                        'base_fair' => $request->input('base_fair'),
                        'risk_level' => $request->input('risk_level'),
                        'risk_title' => $request->input('risk_title'),

                    ]);
                // Update Order Status On Order Table
                $transaction = Transaction::where('transaction_id', $tran_id)
                    ->select('unique_id', 'order_number', 'invoice')
                    ->first()
                    ->toArray();

                Order::where($transaction)->update([
                    'payment_status' => 'paid',
                    'payment_method' => 'online-payment',
                    'paid_amount' => $amount,
                    'due_amount' => 0,
                ]);

                return redirect()->route('order-list')->with([
                    'type' => 'success',
                    'message' => 'Thank you! Your payment was successful and your order is now being processed.'
                ]);
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                Transaction::where('transaction_id', $tran_id)
                    ->update(['status' => 'FAILED']);
                return redirect()->route('order-list')->with([
                    'type' => 'danger',
                    'message' => 'Transaction Failed!. Your order payment mode is now cash on delivery.'
                ]);
            }
        } else if ($transaction->status === 'SUCCESS') {
            return redirect()->route('order-list')->with([
                'type' => 'success',
                'message' => 'Thank you! Your payment was successful and your order is now being processed.'
            ]);
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            return redirect()->route('order-list')->with([
                'type' => 'danger',
                'message' => 'Something went wrong when transaction making. Contact with merchant.'
            ]);
        }
    }

    public function fail($request)
    {
        //dd('fail', $request->all());
        $tran_id = $request->input('tran_id');
        $unique_id = $request->input('value_a');
        if ($request->input('status') === "FAILED") {
            Transaction::where('transaction_id', $tran_id)
                ->update(['status' => 'FAILED', 'message' => $request->input('error')]);
        }

        $transaction = Transaction::where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'transaction_amount')->first();

        if ($transaction->status === 'FAILED') {
            Transaction::where('transaction_id', $tran_id)
                ->update(['status' => 'FAILED']);

            Order::where('unique_id', $unique_id)->update([
                'payment_status' => 'unpaid',
                'payment_method' => 'cash-on-delivery',
                'paid_amount' => 0,
                'due_amount' => $request->input('amount'),
            ]);
            return redirect()->route('order-list')->with([
                'type' => 'danger',
                'message' => 'Transaction Failed!. Your order payment mode is now cash on delivery.'
            ]);
        } else if ($transaction->status === 'SUCCESS') {
            return redirect()->route('order-list')->with([
                'type' => 'success',
                'message' => 'Transaction is already Successful!'
            ]);
        } else {
            return redirect()->route('order-list')->with([
                'type' => 'danger',
                'message' => 'Transaction Failed!. Your order payment mode is now cash on delivery.'
            ]);
        }
    }

    public function cancel($request)
    {
        //dd('cancel',$request->all());
        $tran_id = $request->input('tran_id');
        $unique_id = $request->input('value_a');
        if ($request->input('status') === "CANCELLED") {
            Transaction::where('transaction_id', $tran_id)
                ->update(['status' => 'CANCELLED', 'message' => $request->input('error')]);
        }

        $transaction = Transaction::where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'transaction_amount')->first();

        if ($transaction->status === 'CANCELLED') {
            Order::where('unique_id', $unique_id)->update([
                'payment_status' => 'unpaid',
                'payment_method' => 'cash-on-delivery',
                'paid_amount' => 0,
                'due_amount' => $request->input('amount'),
            ]);
            return redirect()->route('order-list')->with([
                'type' => 'danger',
                'message' => 'Transaction Cancelled!. Your order payment mode is now cash on delivery.'
            ]);
        } else if ($transaction->status === "SUCCESS") {
            return redirect()->route('order-list')->with([
                'type' => 'success',
                'message' => 'Transaction is already Successful!'
            ]);
        } else {
            return redirect()->route('order-list')->with([
                'type' => 'danger',
                'message' => 'Invalid Transaction!. Your order payment mode is now cash on delivery.'
            ]);
        }
    }

    public function ipn($request)
    {
        //dd('ipn',$request->all());
        #Received all the payement information from the gateway
        #Check transation id is posted or not.
        if ($request->input('tran_id')) {

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

                    return redirect()->route('order-list')->with([
                        'type' => 'success',
                        'message' => 'Transaction is successfully Completed!'
                    ]);
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    Transaction::where('transaction_id', $tran_id)
                        ->update(['status' => 'FAILED']);

                    return redirect()->route('order-list')->with([
                        'type' => 'danger',
                        'message' => 'Transaction Failed!. Your order payment mode is now cash on delivery.'
                    ]);
                }
            } else if ($transaction->status === "SUCCESS") {

                #That means Order status already updated. No need to udate database.
                return redirect()->route('order-list')->with([
                    'type' => 'danger',
                    'message' => 'Transaction Failed!. Your order payment mode is now cash on delivery.'
                ]);
            } else {
                #That means something wrong happened. You can redirect customer to your product page.
                return redirect()->route('order-list')->with([
                    'type' => 'danger',
                    'message' => 'Invalid Transaction!. Your order payment mode is now cash on delivery.'
                ]);
            }
        } else {
            return redirect()->route('order-list')->with([
                'type' => 'danger',
                'message' => 'Invalid Data!. Your order payment mode is now cash on delivery.'
            ]);
        }
    }
}
