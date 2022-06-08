<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Frontend\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        // prx($_POST);
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_ID');
            $user_type = "Registered";
        } else {
            $uid = getUserTempId();
            $user_type = "Unregistered";
        }

        $size_id = $request->post('size_id');
        $color_id = $request->post('color_id');
        $pqty = $request->post('pqty');
        $product_id = $request->post('product_id');

        $result = DB::table('product_attrs')
            ->select('product_attrs.id')
            ->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id')
            ->where(['product_id' => $product_id])
            ->where(['sizes.size' => $size_id])
            ->where(['colors.color' => $color_id])
            ->get();

        $product_attr_id = $result[0]->id;

        $getAvaliableQty = getAvaliableQty($product_id, $product_attr_id);

        $finalAvaliable = $getAvaliableQty[0]->pqty - $getAvaliableQty[0]->quantity;

        if ($pqty > $finalAvaliable) {
            return response()->json(['msg' => 'not_avaliable', 'data' => 'Only ' . $finalAvaliable . ' left']);
        }

        // prx($finalAvaliable);
        // die();

        $check = DB::table('carts')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->where(['product_id' => $product_id])
            ->where(['product_attr_id' => $product_attr_id])
            ->get();

        if (isset($check[0])) {
            $update_id = $check[0]->id;

            if ($pqty == 0) {
                DB::table('carts')
                    ->where(['id' => $update_id])
                    ->delete();
                $msg = "Removed";
            } else {
                DB::table('carts')
                    ->where(['id' => $update_id])
                    ->update(['quantity' => $pqty]);
                $msg = "Updated";
            }
        } else {
            $id = DB::table('carts')->insertGetId([
                'user_id' => $uid,
                'user_type' => $user_type,
                'product_id' => $product_id,
                'product_attr_id' => $product_attr_id,
                'quantity' => $pqty,
                'added_on' => date('Y-m-d h:i:s')
            ]);
            $msg = "Added";
        }

        $result = DB::table('carts')
            ->leftJoin('products', 'products.id', '=', 'carts.product_id')
            ->leftJoin('product_attrs', 'product_attrs.id', '=', 'carts.product_attr_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->select('carts.quantity', 'products.name', 'products.image', 'sizes.size', 'colors.color', 'product_attrs.price', 'products.slug', 'products.id as pid', 'product_attrs.id as attr_id')
            ->get();

        return response()->json(['msg' => $msg, 'data' => $result, 'totalItem' => count($result)]);
    }

    public function cart(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_ID');
            $user_type = "Registered";
        } else {
            $uid = getUserTempId();
            $user_type = "Unregistered";
        }

        $result['list'] = DB::table('carts')
            ->leftJoin('products', 'products.id', '=', 'carts.product_id')
            ->leftJoin('product_attrs', 'product_attrs.id', '=', 'carts.product_attr_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->select('carts.quantity', 'products.name', 'products.image', 'sizes.size', 'colors.color', 'product_attrs.price', 'products.slug', 'products.id as pid', 'product_attrs.id as attr_id')
            ->get();

        // prx($result);

        return view('frontend.cart', $result);
    }
}
