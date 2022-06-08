<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $result['orders'] =
            DB::table('orders')
            ->select('orders.*', 'order_status.order_status')
            ->leftJoin('order_status', 'order_status.id', '=', 'orders.order_status')
            ->get();

        // prx($result);

        return view('admin.order.all_order', $result);
    }

    public function order_details(Request $request, $id)
    {
        $result['order_details'] =
            DB::table('order_details')
            ->select('orders.*', 'orders.coupon_code', 'orders.coupon_value', 'orders.total_amount', 'order_details.price', 'order_details.quantity', 'products.name as pname', 'order_status.order_status', 'product_attrs.attr_image', 'sizes.size', 'colors.color')
            ->leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
            ->leftJoin('order_status', 'order_status.id', '=', 'orders.order_status')
            ->leftJoin('product_attrs', 'product_attrs.id', '=', 'order_details.product_attr_id')
            ->leftJoin('products', 'products.id', '=', 'product_attrs.product_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id')
            ->where(['orders.id' => $id])
            ->get();

        $result['order_status'] =
            DB::table('order_status')
            ->get();

        // prx($result['order_status']);

        $result['payment_status'] = ['Pending', 'Success', 'Failed'];

        return view('admin.order.order_details', $result);
    }

    public function update_payment_status(Request $request, $status, $id)
    {
        DB::table('orders')
            ->where(['id' => $id])
            ->update(['payment_status' => $status]);

        // prx($result);

        return redirect('/admin/order_details/' . $id);
    }

    public function update_order_status(Request $request, $status, $id)
    {
        DB::table('orders')
            ->where(['id' => $id])
            ->update(['order_status' => $status]);

        // prx($result);

        return redirect('/admin/order_details/' . $id);
    }

    public function update_track_details(Request $request, $id)
    {
        $track_details = $request->post('track_details');

        DB::table('orders')
            ->where(['id' => $id])
            ->update(['track_details' => $track_details]);

        // prx($result);

        return redirect('/admin/order_details/' . $id);
    }
}
