<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $data = Coupon::query();

        $data->when(request()->get('coupon_code'), function ($query) {
            $query->where('coupon_code', request()->get('coupon_code'));
        });
        $data->when(request()->get('valid_for'), function ($query) {
            $query->where('valid_for', request()->get('valid_for'));
        });
        $data->when(request()->get('discount_type'), function ($query) {
            $query->where('discount_type', request()->get('discount_type'));
        });
        $data->when(request()->get('status'), function ($query) {
            $query->where('status', request()->get('status'));
        });
        $data->latest();
        $coupons = $data->paginate(15);
        return view('admin.coupon.coupon_list', compact('coupons'));
    }

    public function create()
    {
        $route = route('admin.coupons.store');
        return view('admin.coupon.coupon_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'valid_for' => 'required|in:all-user,new-user',
            'coupon_code' => [
                'required',
                'string',
                'max:15',
                Rule::unique('coupons', 'coupon_code')->whereNull('deleted_at')
            ],
            'discount_type' => 'required|in:flat,percentage',
            'discount' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('discount_type') === 'percentage' && ($value < 1 || $value > 99)) {
                        $fail('The discount for a percentage coupon must be between 1 and 99.');
                    }
                },
            ],
            'used_limit' => 'required|integer|min:1',
            'minimum_cost' => ['required', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($request) {
                if ($request->input('discount_type') === 'flat' && $value < $request->input('discount')) {
                    $fail('This value should not less than or equal to discount amount ' . $request->input('discount'));
                }
            }],
            'up_to' => ['required', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($request) {
                if ($request->input('discount_type') === 'flat' && $value <= $request->input('discount')) {
                    $fail('This value should not less than or equal to discount amount ' . $request->input('discount'));
                }
            }],
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive'
        ]);

        $validatedData['created_by'] = Auth::id();
        Coupon::create($validatedData);
        return redirect()->route('admin.coupons.index')->with(successMessage());
    }


    public function edit($id)
    {
        $coupon = Coupon::findOrFail(encrypt_decrypt($id,'decrypt'));
        $route = route('admin.coupons.update', $coupon->id);
        return view('admin.coupon.coupon_add_edit', compact('coupon', 'route'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'valid_for' => 'required|in:all-user,new-user',
            'coupon_code' => [
                'required',
                'string',
                'max:15',
                Rule::unique('coupons', 'coupon_code')->ignore($id)->whereNull('deleted_at')
            ],
            'discount_type' => 'required|in:flat,percentage',
            'discount' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('discount_type') === 'percentage' && ($value < 1 || $value > 99)) {
                        $fail('The discount for a percentage coupon must be between 1 and 99.');
                    }
                },
            ],
            'used_limit' => 'required|integer|min:1',
            'minimum_cost' => ['required', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($request) {
                if ($request->input('discount_type') === 'flat' && $value < $request->input('discount')) {
                    $fail('This value should not less than or equal to discount amount ' . $request->input('discount'));
                }
            }],
            'up_to' => ['required', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($request) {
                if ($request->input('discount_type') === 'flat' && $value <= $request->input('discount')) {
                    $fail('This value should not be less than or equal to the discount amount ' . $request->input('discount'));
                }
            }],
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive'
        ]);

        $coupon = Coupon::findOrFail($id);
        $validatedData['updated_by'] = Auth::id();
        $coupon->update($validatedData);

        return redirect()->route('admin.coupons.index')->with(infoMessage());
    }

    public function updateCouponStatus($id): \Illuminate\Http\JsonResponse
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = $coupon->status === 'active' ? 'inactive' : 'active';
        if ($coupon->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Coupon status updated successfully.',
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update category status.',
        ], 500);
    }


    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->deleted_by = Auth::id();
        $coupon->save();
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with(deleteMessage());
    }
}
