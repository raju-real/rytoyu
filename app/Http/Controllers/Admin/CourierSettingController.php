<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourierSettingController extends Controller
{
    public function courierSettings()
    {
        return view('admin.settings.courier_settings');
    }

    public function updateCourierSettings(Request $request)
    {
        $this->validate($request, [
            'steadfast_status' => 'nullable|string',
            'steadfast_api_key' => 'nullable|string',
            'steadfast_secret_key' => 'nullable|string',
            'pathao_status' => 'nullable|string',
            'pathao_client_id' => 'nullable|string',
            'pathao_client_secret' => 'nullable|string',
            'pathao_username' => 'nullable|string',
            'pathao_password' => 'nullable|string',
            'pathao_store_id' => 'nullable|string',
        ]);

        $keys = array_keys($request->except(['_token', '_method']));
        $setting_data = [];

        // Setup defaults for statuses
        $defaults = [
            'steadfast_status' => '0',
            'pathao_status' => '0'
        ];

        // Retrieve existing settings
        $existing_settings = courierSettings();

        // Populate setting data
        foreach ($existing_settings as $key => $val) {
            $setting_data[$key] = $val;
        }

        foreach ($defaults as $key => $default_val) {
            $setting_data[$key] = $request->input($key, $default_val);
        }

        foreach ($keys as $key) {
            if (!array_key_exists($key, $defaults)) {
                // Keep old values if empty, otherwise update
                $setting_data[$key] = $request->input($key, $existing_settings[$key] ?? '');
            }
        }

        $newJsonString = json_encode($setting_data, JSON_PRETTY_PRINT);
        file_put_contents(base_path('assets/common/json/courier_settings.json'), $newJsonString);

        return redirect()->back()->with(infoMessage('success', 'Courier Settings have been updated successfully!'));
    }
}
