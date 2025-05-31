<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DeliveryCharge;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeliveryChargeController extends Controller
{
    public function index()
    {
        $data = DeliveryCharge::query();
        $data->when(request()->get('district_name'), function ($query) {
            $district_name = request()->get('district_name');
            $query->where('district_name', "LIKE", "%{$district_name}%");
        });
        $data->when(request()->get('status'), function ($query) {
            $query->where('status', request()->get('status'));
        });
        $delivery_charges = $data->paginate(15);
        return view('admin.settings.delivery_charge_list', compact('delivery_charges'));
    }

    public function create()
    {
        $route = route('admin.delivery-charges.store');
        return view('admin.settings.delivery_charge_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'district_name' => [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('delivery_charges', 'district_name')->whereNull('deleted_at')
                ],
                'delivery_charge' => 'required|numeric|min:0',
                'status' => 'required|max:10|in:active,inactive'
            ]
        );
        $delivery_charge = new DeliveryCharge();
        $delivery_charge->district_name = $request->district_name;
        $delivery_charge->slug = Str::slug($request->district_name);
        $delivery_charge->delivery_charge = $request->delivery_charge ?? 0.00;
        $delivery_charge->status = $request->status;
        $delivery_charge->created_by = Auth::id();
        $delivery_charge->save();
        return redirect()->route('admin.delivery-charges.index')->with(successMessage());
    }


    public function edit($slug)
    {
        $charge = DeliveryCharge::whereSlug($slug)->first();
        $route = route('admin.delivery-charges.update', $charge->id);
        return view('admin.settings.delivery_charge_add_edit', compact('charge', 'route'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'district_name' => [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('delivery_charges', 'district_name')->whereNull('deleted_at')->ignore($id)
                ],
                'delivery_charge' => 'required|numeric|min:0',
                'status' => 'required|max:10|in:active,inactive'
            ]
        );
        $delivery_charge = DeliveryCharge::findOrFail($id);
        $delivery_charge->district_name = $request->district_name;
        $delivery_charge->slug = Str::slug($request->district_name);
        $delivery_charge->delivery_charge = $request->delivery_charge ?? 0.00;
        $delivery_charge->status = $request->status;
        $delivery_charge->created_by = Auth::id();
        $delivery_charge->save();
        return redirect()->route('admin.delivery-charges.index')->with(infoMessage());
    }

    public function updateDeliveryChargeStatus($id): \Illuminate\Http\JsonResponse
    {
        $charge = DeliveryCharge::findOrFail($id);
        $charge->status = $charge->status === 'active' ? 'inactive' : 'active';
        if ($charge->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'DeliveryCharge status updated successfully.',
            ]);
        }
        // Optional: Handle failure case if needed
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update category status.',
        ], 500);
    }


    public function destroy($id)
    {
        //DeliveryCharge::findOrFail($id)->delete();
        return redirect()->route('admin.delivery-charges.index')->with(deleteMessage());
    }

}
