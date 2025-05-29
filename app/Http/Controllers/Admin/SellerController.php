<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Rules\RatioRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function index()
    {
        $data = Admin::query();
        $data->latest();
        $data->when(request()->get('search'), function ($query) {
            $search = request()->get('search');
            $query->where('name', "LIKE", "%{$search}%")
                ->orWhere('code', $search)
                ->orWhere('email', $search)
                ->orWhere('mobile', $search);
        });

        $data->when(request()->get('status'), function ($query) {
            $query->where('status', request()->get('status'));
        });
        $data->seller();
        $sellers = $data->paginate(20);
        return view('admin.seller.seller_list', compact('sellers'));
    }

    public function create()
    {
        $route = route('admin.sellers.store');
        return view('admin.seller.seller_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'email' => [
                'required',
                'email',
                'max:30',
                Rule::unique('admins', 'email')->whereNull('deleted_at')
            ],
            'password' => 'required|max:15',
            'commission_rate' => [
                'required',
                'numeric',
                new RatioRule(),
                function ($attribute, $value, $fail) {
                    if ($value > 100.00) {
                        $fail('The Commission Rate must not be greater than 100.00.');
                    }
                },
            ],

            'mobile' => [
                'required',
                'string',
                'min:11',
                'max:11',
                Rule::unique('admins', 'mobile')->whereNull('deleted_at')
            ],
            'image' => 'nullable|sometimes|mimes:jpg,jpeg,png|max:1024',
            'request_status' => 'required|in:pending,approved',
            'status' => 'required|in:active,inactive',
        ]);

        $seller = new Admin();
        $seller->code = Admin::getCode();
        $seller->type = 'seller';
        $seller->name = $request->name;
        $seller->email = $request->email;
        $seller->mobile = $request->mobile;
        $seller->password_plain = $request->password;
        $seller->password = Hash::make($request->password);
        if ($request->file('image')) {
            $seller->image = uploadImage($request->file('image'), 'admin');
        }
        $seller->request_status = $request->request_status;
        $seller->status = $request->status;
        $seller->commission_rate = $request->commission_rate ?? 0.00;
        $seller->created_by = Auth::id();
        $seller->save();
        return redirect()->route('admin.sellers.index')->with(successMessage());
    }


    public function edit($code)
    {
        $seller = Admin::whereCode($code)->firstOrFail();
        $route = route('admin.sellers.update', $seller->id);
        return view('admin.seller.seller_add_edit', compact('seller', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'email' => [
                'required',
                'email',
                'max:30',
                Rule::unique('admins', 'email')->whereNull('deleted_at')->ignore($id)
            ],
            'password' => 'nullable|sometimes|max:15',
            'commission_rate' => [
                'required',
                'numeric',
                new RatioRule(),
                function ($attribute, $value, $fail) {
                    if ($value > 100.00) {
                        $fail('The Commission Rate must not be greater than 100.00.');
                    }
                },
            ],
            'mobile' => [
                'required',
                'string',
                'min:11',
                'max:11',
                Rule::unique('admins', 'mobile')->whereNull('deleted_at')->ignore($id)
            ],
            'image' => 'nullable|sometimes|mimes:jpg,jpeg,png|max:1024',
            'request_status' => 'required|in:pending,approved',
            'status' => 'required|in:active,inactive'
        ]);

        $seller = Admin::findOrFail($id);
        $seller->name = $request->name;
        $seller->email = $request->email;
        $seller->mobile = $request->mobile;
        if ($request->password) {
            $seller->password_plain = $request->password;
            $seller->password = Hash::make($request->password);
        }
        if ($request->file('image')) {
            if ($seller->image !== null and file_exists($seller->image)) {
                unlink($seller->image);
            }
            $seller->image = uploadImage($request->file('image'), 'admin');
        }
        $seller->request_status = $request->request_status;
        $seller->status = $request->status;
        $seller->commission_rate = $request->commission_rate ?? 0.00;
        $seller->save();
        return redirect()->route('admin.sellers.index')->with(infoMessage());
    }

    public function updateSellerStatus($id): \Illuminate\Http\JsonResponse
    {
        $seller = Admin::findOrFail($id);
        $seller->status = $seller->status === 'active' ? 'inactive' : 'active';
        if ($seller->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Seller status updated successfully.',
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update seller status.',
        ], 500);
    }

    public function updateSellerRequestStatus($id): \Illuminate\Http\JsonResponse
    {
        $seller = Admin::findOrFail($id);
        $seller->request_status = $seller->request_status === 'approved' ? 'pending' : 'approved';
        if ($seller->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Seller request status updated successfully.',
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update seller request status.',
        ], 500);
    }

    public function showSellerInfo($seller_code = null)
    {
        $seller = Admin::with('shop')
            ->whereCode($seller_code)
            ->select('id', 'code', 'name', 'email', 'mobile', 'commission_rate', 'image', 'status')
            ->firstOrFail();

        // Hide attributes from the related shop
        if ($seller->relationLoaded('shop') && $seller->shop) {
            $seller->shop->makeHidden(['created_at', 'updated_at']);
        }

        $html =  view('admin.seller.seller_info', compact('seller'))->render();
        return response()->json([
            'title' => 'Seller Information',
            'html' => $html
        ]);
        
    }


    public function destroy($id)
    {
        Admin::findOrFail($id)->delete();
        return redirect()->route('admin.sellers.index')->with(deleteMessage());
    }
}
