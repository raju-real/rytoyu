<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class OrderController extends Controller
{
    public function orderList()
    {
        $order = Order::query();
        $order->where('user_id', Auth::id());
        $order->when(request()->get('search'), function ($query) {
            $searchParam = request()->get('search');
            $query->where('invoice', "LIKE", "%{$searchParam}%");
            $query->orWhere('mobile', "LIKE", "%{$searchParam}%");
        });
        $orders = $order->latest()->paginate(3);
        return view('user.account.order_list', compact('orders'));
    }

    public function orderDetails($unique_id)
    {
        $order = Order::where('user_id', Auth::id())->where('unique_id', $unique_id)->firstOrFail();
        return view('user.account.order_details', compact('order'));
    }

    public function orderInvoice($unique_id)
    {
        $order = Order::orderByUniqueId($unique_id);
        $file = PDF::loadView('pdf.order_invoice', compact('order'));
        return $file->stream();
    }

    public function submitReview($combine_id)
    {
        $parts = explode('-', $combine_id);
        //$order_id = $parts[0];
        $order_product_id = $parts[1];
        $order_product = OrderProduct::with('review')->where('id',$order_product_id)->where("user_id",Auth::id())->where('order_status','delivered')->firstOrFail();
        return view('user.account.submit_review',compact('order_product'));
    }

    public function storeReview(Request $request, $order_product_id)
    {
        $this->validate($request,[
            'rating' => 'required|in:1,2,3,4,5',
            'comment' => 'required|max:1000'
        ]);

        $order_product = OrderProduct::with('review')->where('id',$order_product_id)->where("user_id",Auth::id())->where('order_status','delivered')->firstOrFail();
        if($order_product->review) {
            $review = Review::findOrFail($order_product->review->id);
        } else {
            $review = new Review();
        }
        $review->user_id = Auth::id();
        $review->order_id = $order_product->order_id;
        $review->order_product_id = $order_product->id;
        $review->product_id = $order_product->product_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();
        return redirect()->route('order-details',$order_product->order->unique_id)->with('message','Thank you for your review! We truly appreciate you taking the time to share your experience.');
    }
}
