<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupon.all_coupon', ['coupons' => $coupons]);
    }

    public function manage_coupon(Request $request, $coupon_id = '')
    {
        if ($coupon_id > 0) {
            $coupon = Coupon::where(['id' => $coupon_id])->get();
            $result['title'] = $coupon['0']->title;
            $result['code'] = $coupon['0']->code;
            $result['value'] = $coupon['0']->value;

            $result['type'] = $coupon['0']->type;
            $result['min_order_amount'] = $coupon['0']->min_order_amount;
            $result['is_one_time'] = $coupon['0']->is_one_time;

            $result['id'] = $coupon['0']->id;
        } else {
            $result['title'] = '';
            $result['code'] = '';
            $result['value'] = '';

            $result['type'] = '';
            $result['min_order_amount'] = '';
            $result['is_one_time'] = '';

            $result['id'] = 0;
        }

        return view('admin.coupon.manage_coupon', $result);
    }

    public function manage_coupon_process(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required|unique:coupons,code,' . $request->post('id'),
            'value' => 'required'
        ]);

        if ($request->post('id') > 0) {
            $coupon = Coupon::find($request->post('id'));
            $msg = "Coupon has been updated successfully!";
        } else {
            $coupon = new Coupon();
            $coupon->status = 1;
            $msg = "Coupon has been created successfully!";
        }

        $coupon->title = $request->post('title');
        $coupon->code = $request->post('code');
        $coupon->value = $request->post('value');

        $coupon->type = $request->post('type');
        $coupon->min_order_amount = $request->post('min_order_amount');
        $coupon->is_one_time = $request->post('is_one_time');

        $coupon->save();

        $request->session()->flash('message', $msg);

        return redirect('admin/coupon');
    }

    public function delete_coupon(Request $request, $coupon_id)
    {
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        $request->session()->flash('message', 'Coupon has been deleted successfully!');
        return redirect('admin/coupon');
    }

    public function coupon_status(Request $request, $status, $coupon_id)
    {
        $coupon = Coupon::find($coupon_id);
        $coupon->status = $status;
        $coupon->save();
        $request->session()->flash('message', 'Coupon status has been updated successfully!');
        return redirect('admin/coupon');
    }
}
