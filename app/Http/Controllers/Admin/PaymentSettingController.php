<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function paymentSettings()
    {
        return view('admin.settings.payment_settings');
    }

    public function updatePaymentSettings(Request $request)
    {
        $this->validate($request, [
            'sslcommerz_status' => 'nullable|string',
            'sslcommerz_store_id' => 'nullable|string',
            'sslcommerz_store_password' => 'nullable|string',
            'sslcommerz_mode' => 'nullable|string',
            'bkash_status' => 'nullable|string',
            'bkash_app_key' => 'nullable|string',
            'bkash_app_secret' => 'nullable|string',
            'bkash_username' => 'nullable|string',
            'bkash_password' => 'nullable|string',
            'bkash_mode' => 'nullable|string',
            'rocket_status' => 'nullable|string',
            'rocket_merchant_account' => 'nullable|string',
            'rocket_mode' => 'nullable|string',
            'nagad_status' => 'nullable|string',
            'nagad_merchant_id' => 'nullable|string',
            'nagad_merchant_number' => 'nullable|string',
            'nagad_public_key' => 'nullable|string',
            'nagad_private_key' => 'nullable|string',
            'nagad_mode' => 'nullable|string',
        ]);

        $keys = array_keys($request->except(['_token', '_method']));
        $setting_data = [];
        
        // Setup defaults for statuses
        $defaults = [
            'sslcommerz_status' => '0',
            'bkash_status' => '0',
            'rocket_status' => '0',
            'nagad_status' => '0'
        ];

        // Retrieve existing settings
        $existing_settings = paymentSettings();

        // Populate setting data
        foreach ($existing_settings as $key => $val) {
            $setting_data[$key] = $val;
        }

        foreach ($defaults as $key => $default_val) {
            $setting_data[$key] = $request->input($key, $default_val);
        }

        foreach ($keys as $key) {
            if(!array_key_exists($key, $defaults)) {
                // Keep old values if empty, otherwise update
                $setting_data[$key] = $request->input($key, $existing_settings[$key] ?? '');
            }
        }

        $newJsonString = json_encode($setting_data, JSON_PRETTY_PRINT);
        file_put_contents(base_path('assets/common/json/payment_settings.json'), $newJsonString);

        return redirect()->back()->with(infoMessage('success', 'Payment Settings have been updated successfully!'));
    }
}
