<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    public function product_review(Request $request)
    {
        $result['product_review'] =
            DB::table('product_review')
            ->leftJoin('customers', 'customers.id', '=', 'product_review.customer_id')
            ->leftJoin('products', 'products.id', '=', 'product_review.product_id')
            // ->where(['product_review.status' => 1])
            ->orderBy('product_review.added_on', 'desc')
            ->select('product_review.id', 'product_review.status', 'product_review.rating', 'product_review.review', 'product_review.added_on', 'customers.name', 'products.name as pname')
            ->get();

        // prx($result['product_review']);

        // $request->session()->flash('message', 'Product status has been updated successfully!');
        return view('admin.product_review.all_product_review', $result);
    }

    public function update_product_review(Request $request, $status, $product_id)
    {
        $product_review = ProductReview::find($product_id);
        $product_review->status = $status;
        $product_review->save();
        $request->session()->flash('message', 'Product Review status has been updated successfully!');
        return redirect('admin/product_review');
    }
}
