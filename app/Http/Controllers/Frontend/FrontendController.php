<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Crypt;
use Mail;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // getData();
        // die();

        $result['home_categories'] = DB::table('categories')->where(['status' => 1])->where(['is_home' => 1])->get();

        foreach ($result['home_categories'] as $list) {
            $result['home_categories_product'][$list->id] =
                DB::table('products')
                ->where(['status' => 1])
                ->where(['category_id' => $list->id])
                ->get();

            foreach ($result['home_categories_product'][$list->id] as $list1) {
                $result['home_product_attr'][$list1->id] =
                    DB::table('product_attrs')
                    ->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id')
                    ->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id')
                    ->where(['product_attrs.product_id' => $list1->id])
                    ->get();
            }
        }

        $result['home_brands'] = DB::table('brands')->where(['status' => 1])->where(['is_home' => 1])->get();

        $result['home_featured_product'][$list->id] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['is_featured' => 1])
            ->get();

        foreach ($result['home_featured_product'][$list->id] as $list1) {
            $result['home_featured_product_attr'][$list1->id] =
                DB::table('product_attrs')
                ->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id')
                ->where(['product_attrs.product_id' => $list1->id])
                ->get();
        }

        $result['home_trending_product'][$list->id] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['is_trending' => 1])
            ->get();

        foreach ($result['home_trending_product'][$list->id] as $list1) {
            $result['home_trending_product_attr'][$list1->id] =
                DB::table('product_attrs')
                ->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id')
                ->where(['product_attrs.product_id' => $list1->id])
                ->get();
        }

        $result['home_discounted_product'][$list->id] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['is_discounted' => 1])
            ->get();

        foreach ($result['home_discounted_product'][$list->id] as $list1) {
            $result['home_discounted_product_attr'][$list1->id] =
                DB::table('product_attrs')
                ->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id')
                ->where(['product_attrs.product_id' => $list1->id])
                ->get();
        }

        $result['home_banner'] = DB::table('home_banners')->where(['status' => 1])->get();

        // echo "<pre>";
        // print_r($result);
        // die();

        return view('frontend.index', $result);
    }

    public function product(Request $request, $product_slug)
    {
        $result['product'] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['slug' => $product_slug])
            ->get();

        foreach ($result['product'] as $list) {
            $result['product_attr'][$list->id] =
                DB::table('product_attrs')
                ->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id')
                ->where(['product_attrs.product_id' => $list->id])
                ->get();
        }

        foreach ($result['product'] as $list) {
            $result['product_images'][$list->id] =
                DB::table('product_images')
                ->where(['product_images.product_id' => $list->id])
                ->get();
        }

        $result['related_product'] =
            DB::table('products')
            ->where(['status' => 1])
            ->where('slug', '!=', $result['product'][0]->slug)
            ->where(['category_id' => $result['product'][0]->category_id])
            ->get();

        foreach ($result['related_product'] as $list) {
            $result['related_product_attr'][$list->id] =
                DB::table('product_attrs')
                ->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id')
                ->where(['product_attrs.product_id' => $list->id])
                ->get();
        }

        $result['product_review'] =
            DB::table('product_review')
            ->leftJoin('customers', 'customers.id', '=', 'product_review.customer_id')
            ->where(['product_review.product_id' => $result['product'][0]->id])
            ->where(['product_review.status' => 1])
            ->orderBy('product_review.added_on', 'desc')
            ->select('product_review.rating', 'product_review.review', 'product_review.added_on', 'customers.name')
            ->get();

        // prx($result['product_review']);

        return view('frontend.product', $result);
    }

    public function category(Request $request, $category_slug)
    {
        // $slug = "";

        $sort = "";
        $sort_txt = "";

        $filter_price_start = "";
        $filter_price_end = "";

        $color_filter = "";

        $colorFilterArr = [];

        if ($request->get('sort') !== null) {
            $sort = $request->get('sort');
        }

        $query = DB::table('products');
        $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        $query = $query->leftJoin('product_attrs', 'products.id', '=', 'product_attrs.product_id');
        $query = $query->where(['products.status' => 1]);
        $query = $query->where(['categories.category_slug' => $category_slug]);
        if ($sort == 'name') {
            $query = $query->orderBy('products.name', 'asc');
            $sort_txt = "Product Name";
        }
        if ($sort == 'date') {
            $query = $query->orderBy('products.id', 'desc');
            $sort_txt = "Date";
        }
        if ($sort == 'price_desc') {
            $query = $query->orderBy('product_attrs.price', 'desc');
            $sort_txt = "Price - DESC";
        }
        if ($sort == 'price_asc') {
            $query = $query->orderBy('product_attrs.price', 'asc');
            $sort_txt = "Price - ASC";
        }
        if ($request->get('filter_price_start') !== null && $request->get('filter_price_end') !== null) {
            $filter_price_start = $request->get('filter_price_start');
            $filter_price_end = $request->get('filter_price_end');

            if ($filter_price_start > 0 && $filter_price_end > 0) {
                $query = $query->whereBetween('product_attrs.price', [$filter_price_start, $filter_price_end]);
            }
        }

        if ($request->get('color_filter') !== null) {

            $color_filter = $request->get('color_filter');

            $colorFilterArr = explode(":", $color_filter);

            $colorFilterArr = array_filter($colorFilterArr);

            // prx($colorFilterArr);

            $query = $query->where(['product_attrs.color_id' => $request->get('color_filter')]);
        }

        $query = $query->distinct()->select('products.*');
        $query = $query->get();
        $result['product'] = $query;

        foreach ($result['product'] as $list1) {

            $query1 = DB::table('product_attrs');
            $query1 = $query1->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id');
            $query1 = $query1->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id');
            $query1 = $query1->where(['product_attrs.product_id' => $list1->id]);

            $query1 = $query1->get();

            // prx($query1);

            $result['product_attr'][$list1->id] = $query1;
        }

        $result['colors'] = DB::table('colors')
            ->where(['status' => 1])
            ->get();

        $result['categories_left'] = DB::table('categories')
            ->where(['status' => 1])
            ->get();

        // prx($result['categories_left']);

        $result['slug'] = $category_slug;

        $result['sort'] = $sort;
        $result['sort_txt'] = $sort_txt;

        $result['filter_price_start'] = $filter_price_start;
        $result['filter_price_end'] = $filter_price_end;

        $result['color_filter'] = $color_filter;

        $result['colorFilterArr'] = $colorFilterArr;

        // prx($result);

        return view('frontend.category', $result);

        // $sort = "";
        // $sort_txt = "";
        // if ($request->get('sort') !== null) {
        //     $sort = $request->get('sort');
        // }

        // $query = DB::table('products');
        // $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        // $query = $query->leftJoin('product_attrs', 'products.id', '=', 'product_attrs.product_id');
        // $query = $query->where(['products.status' => 1]);
        // $query = $query->where(['categories.category_slug' => $category_slug]);

        // if ($sort == 'name') {
        //     $query = $query->orderBy('products.name', 'asc');
        //     $sort_txt = "Product Name";
        // }
        // if ($sort == 'date') {
        //     $query = $query->orderBy('products.id', 'desc');
        //     $sort_txt = "Date";
        // }
        // if ($sort == 'price_desc') {
        //     $query = $query->orderBy('product_attrss.price', 'desc');
        //     $sort_txt = "Price - DESC";
        // }
        // if ($sort == 'price_asc') {
        //     $query = $query->orderBy('product_attrss.price', 'asc');
        //     $sort_txt = "Price - ASC";
        // }

        // $query = $query->distinct()->select('products.*');
        // $query = $query->get();

        // $result['product'] = $query;

        // foreach ($result['product'] as $list1) {

        //     // echo '<pre>';
        //     // print_r($list1);

        //     $query1 = DB::table('product_attrs');
        //     $query1 = $query1->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id');
        //     $query1 = $query1->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id');
        //     $query1 = $query1->where(['product_attrs.product_id' => $list1->id]);

        //     $query1 = $query1->get();
        // }

        // $result['product_attr'][$list1->id] = $query1;

        // // die();
        // // dd($result);

        // $result['sort'] = $sort;
        // $result['sort_txt'] = $sort_txt;

        // return view('frontend.category', $result);
    }

    public function search(Request $request, $searchTerm)
    {
        $result['product'] = $query = DB::table('products');
        $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        $query = $query->leftJoin('product_attrs', 'products.id', '=', 'product_attrs.product_id');
        $query = $query->where(['products.status' => 1]);
        $query = $query->where('name', 'like', "%$searchTerm%");
        $query = $query->orwhere('model', 'like', "%$searchTerm%");
        $query = $query->orwhere('short_description', 'like', "%$searchTerm%");
        $query = $query->orwhere('description', 'like', "%$searchTerm%");
        $query = $query->orwhere('keywords', 'like', "%$searchTerm%");
        $query = $query->orwhere('technical_specification', 'like', "%$searchTerm%");

        $query = $query->distinct()->select('products.*');
        $query = $query->get();
        $result['product'] = $query;

        foreach ($result['product'] as $list1) {

            $query1 = DB::table('product_attrs');
            $query1 = $query1->leftJoin('sizes', 'sizes.id', '=', 'product_attrs.size_id');
            $query1 = $query1->leftJoin('colors', 'colors.id', '=', 'product_attrs.color_id');
            $query1 = $query1->where(['product_attrs.product_id' => $list1->id]);

            $query1 = $query1->get();

            // prx($query1);

            $result['product_attr'][$list1->id] = $query1;
        }

        // prx($result['categories_left']);

        // prx($result);

        return view('frontend.search', $result);
    }

    public function register(Request $request)
    {

        return view('frontend.register');
    }

    public function registration_process(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required',
            'mobile' => 'required|numeric|digits:10',
        ]);

        if (!$valid->passes()) {
            return response()->json(['status' => 'error', 'error' => $valid->errors()->toArray()]);
        } else {
            $rand_id = rand(111111111, 999999999);
            $arr = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Crypt::encrypt($request->password),
                "mobile" => $request->mobile,
                "status" => 1,
                "is_verified" => 0,
                "rand_id" => $rand_id,
                "created_at" => date('Y-m-d h:i:s'),
                "updated_at" => date('Y-m-d h:i:s')
            ];

            $query = DB::table('customers')->insert($arr);

            if ($query) {

                $data = ['name' => $request->name, 'rand_id' => $rand_id];
                $user['to'] = $request->email;
                Mail::send('frontend.email_verification', $data, function ($messages) use ($user) {
                    $messages->to($user['to']);
                    $messages->subject('Email Id Verification!');
                });

                return response()->json(['status' => 'success', 'msg' => 'Registration Successfully! Please check your email id for verification.']);
            }
        }
    }

    public function login_process(Request $request)
    {
        // prx($_POST);
        $result = DB::table('customers')
            ->where(['email' => $request->str_login_email])
            ->get();

        if (isset($result[0])) {

            $db_pwd = Crypt::decrypt($result[0]->password);
            $status = $result[0]->status;
            $is_verified = $result[0]->is_verified;

            if ($is_verified == 0) {
                return response()->json(['status' => 'error', 'msg' => 'Please verify your email id.']);
            }

            if ($status == 0) {
                return response()->json(['status' => 'error', 'msg' => 'Your account has been deactivated.']);
            }

            if ($db_pwd == $request->str_login_password) {

                if ($request->rememberme === null) {
                    setcookie('login_email', $request->str_login_email, 100);
                    setcookie('login_password', $request->str_login_password, 100);
                } else {
                    setcookie('login_email', $request->str_login_email, time() + 60 * 60 * 24 * 365);
                    setcookie('login_password', $request->str_login_password, time() + 60 * 60 * 24 * 365);
                }

                // die();

                $request->session()->put('FRONT_USER_LOGIN', true);
                $request->session()->put('FRONT_USER_ID', $result[0]->id);
                $request->session()->put('FRONT_USER_NAME', $result[0]->name);
                $status = "success";
                $msg = "";

                $getUserTempId = getUserTempId();

                DB::table('carts')
                    ->where(['user_id' => $getUserTempId, 'user_type' => 'Unregistered'])
                    ->update(['user_id' => $result[0]->id, 'user_type' => 'Registered']);
            } else {
                $status = "error";
                $msg = "Please enter valid password";
            }
        } else {
            $status = "error";
            $msg = "Please enter valid email id";
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function email_verification(Request $request, $rand_id)
    {
        $result = DB::table('customers')
            ->where(['rand_id' => $rand_id])
            ->where(['is_verified' => 0])
            ->get();

        if (isset($result[0])) {
            DB::table('customers')
                ->where(['id' => $result[0]->id])
                ->update(['is_verified' => 1, 'rand_id' => '']);
            return view('frontend.verification');
        } else {
            return redirect('/');
        }

        // echo '<pre>';
        // print_r($result);
    }

    public function forgot_password(Request $request)
    {
        $result = DB::table('customers')
            ->where(['email' => $request->str_forgot_email])
            ->get();

        $rand_id = rand(111111111, 999999999);

        if (isset($result[0])) {

            DB::table('customers')
                ->where(['email' => $request->str_forgot_email])
                ->update(['is_forgot_password' => 1, 'rand_id' => $rand_id]);

            $data = ['name' => $result[0]->name, 'rand_id' => $rand_id];
            $user['to'] = $request->str_forgot_email;
            Mail::send('frontend.forgot_email', $data, function ($messages) use ($user) {
                $messages->to($user['to']);
                $messages->subject('Forgot Password!');
            });

            return response()->json(['status' => 'success', 'msg' => 'Please check your email for change password!']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Email id not registered!']);
        }
    }

    public function forgot_password_change(Request $request, $rand_id)
    {
        $result = DB::table('customers')
            ->where(['rand_id' => $rand_id])
            ->where(['is_forgot_password' => 1])
            ->get();

        if (isset($result[0])) {

            $request->session()->put('FORGOT_PASSWORD_USER_ID', $result[0]->id);

            return view('frontend.forgot_password_change');
        } else {
            return redirect('/');
        }

        // echo '<pre>';
        // print_r($result);
    }

    public function forgot_password_change_process(Request $request)
    {
        // FORGOT_PASSWORD_USER_ID
        DB::table('customers')
            ->where(['id' => $request->session()->get('FORGOT_PASSWORD_USER_ID')])
            ->update(
                [
                    'is_forgot_password' => 0,
                    'rand_id' => '',
                    'password' => Crypt::encrypt($request->password)
                ]
            );

        return response()->json(['status' => 'success', 'msg' => 'Password has been changed succesfully!']);

        // echo '<pre>';
        // print_r($result);
    }

    public function Checkout(Request $request)
    {
        $result['cart_data'] = getAddToCartTotalItem();

        if (isset($result['cart_data'][0])) {

            if ($request->session()->has('FRONT_USER_LOGIN')) {
                $uid = $request->session()->get('FRONT_USER_ID');

                $customer_info = DB::table('customers')
                    ->where(['id' => $uid])
                    ->get();

                $result['customers']['name'] = $customer_info[0]->name;
                $result['customers']['email'] = $customer_info[0]->email;
                $result['customers']['mobile'] = $customer_info[0]->mobile;
                $result['customers']['address'] = $customer_info[0]->address;
                $result['customers']['city'] = $customer_info[0]->city;
                $result['customers']['state'] = $customer_info[0]->state;
                $result['customers']['zipcode'] = $customer_info[0]->zipcode;

                // prx($customer_info);
            } else {

                $result['customers']['name'] = "";
                $result['customers']['email'] = "";
                $result['customers']['mobile'] = "";
                $result['customers']['address'] = "";
                $result['customers']['city'] = "";
                $result['customers']['state'] = "";
                $result['customers']['zipcode'] = "";
            }

            return view('frontend.checkout', $result);
        } else {
            return redirect('/');
            // return view('frontend.checkout', $result);
        }
    }

    public function apply_coupon_code(Request $request)
    {
        $arr = apply_coupon_code($request->coupon_code);

        $arr = json_decode($arr, true);

        // prx($arr);

        return response()->json(['status' => $arr['status'], 'msg' => $arr['msg'], 'totalPrice' => $arr['totalPrice']]);
    }

    public function remove_coupon_code(Request $request)
    {
        $totalPrice = 0;

        // prx($_POST);
        $result = DB::table('coupons')
            ->where(['code' => $request->coupon_code])
            ->get();

        // prx($result);

        // $value = $result[0]->value;
        // $type = $result[0]->type;

        $getAddToCartTotalItem = getAddToCartTotalItem();

        $totalPrice = 0;
        foreach ($getAddToCartTotalItem as $list) {
            $totalPrice = $totalPrice + ($list->quantity * $list->price);
        }

        return response()->json(['status' => 'success', 'msg' => "Coupon code removed successfully!", 'totalPrice' => $totalPrice]);
    }

    public function place_order(Request $request)
    {
        $payment_url = '';
        $rand_id = rand(111111111, 999999999);

        if ($request->session()->has('FRONT_USER_LOGIN')) {
        } else {

            $valid = Validator::make($request->all(), [
                'email' => 'required|email|unique:customers,email',
            ]);

            if (!$valid->passes()) {
                return response()->json(['status' => 'error', 'msg' => "The email has already been taken."]);
            } else {

                $arr = [
                    "name" => $request->name,
                    "email" => $request->email,
                    "password" => Crypt::encrypt($rand_id),
                    "mobile" => $request->mobile,
                    "address" => $request->address,
                    "city" => $request->city,
                    "state" => $request->state,
                    "zipcode" => $request->zipcode,
                    "status" => 1,
                    "is_verified" => 0,
                    "rand_id" => $rand_id,
                    "created_at" => date('Y-m-d h:i:s'),
                    "updated_at" => date('Y-m-d h:i:s'),
                    "is_forgot_password" => 0
                ];

                $user_id = DB::table('customers')->insert($arr);
                $request->session()->put('FRONT_USER_LOGIN', true);
                $request->session()->put('FRONT_USER_ID', $user_id);
                $request->session()->put('FRONT_USER_NAME', $request->name);

                $data = ['name' => $request->name, 'password' => $rand_id];
                $user['to'] = $request->email;
                Mail::send('frontend.password_send', $data, function ($messages) use ($user) {
                    $messages->to($user['to']);
                    $messages->subject('New Password!');
                });

                $getUserTempId = getUserTempId();

                DB::table('carts')
                    ->where(['user_id' => $getUserTempId, 'user_type' => 'Unregistered'])
                    ->update(['user_id' => $user_id, 'user_type' => 'Registered']);

                // die();
            }
        }

        $coupon_value = 0;

        if ($request->coupon_code != '') {
            $arr = apply_coupon_code($request->coupon_code);

            $arr = json_decode($arr, true);

            if ($arr['status'] == 'success') {

                $coupon_value = $arr['coupon_code_value'];

                $coupon_code_value = $arr['status'];
            } else {

                return response()->json(['status' => 'false', 'msg' => $arr['msg']]);
            }
        }

        $uid = $request->session()->get('FRONT_USER_ID');

        $totalPrice = 0;

        $getAddToCartTotalItem = getAddToCartTotalItem();

        foreach ($getAddToCartTotalItem as $list) {
            $totalPrice = $totalPrice + ($list->quantity * $list->price);
        }

        $arr = [
            "customer_id" => $uid,
            "name" => $request->name,
            "email" => $request->email,
            "mobile" => $request->mobile,
            "address" => $request->address,
            "city" => $request->city,
            "state" => $request->state,
            "zipcode" => $request->zipcode,
            "coupon_code" => $request->coupon_code,
            "coupon_value" => $coupon_value,
            "order_status" => 1,
            "payment_type" => $request->payment_type,
            "payment_status" => "Pending",
            "total_amount" => $totalPrice,
            "order_status" => 1,
            "added_on" => date('Y-m-d h:i:s')
        ];

        $order_id = DB::table('orders')->insertGetId($arr);

        if ($order_id > 0) {
            foreach ($getAddToCartTotalItem as $list) {

                $productDetailsArr['product_id'] = $list->pid;
                $productDetailsArr['order_id'] = $order_id;
                $productDetailsArr['product_attr_id'] = $list->attr_id;
                $productDetailsArr['price'] = $list->price;
                $productDetailsArr['quantity'] = $list->quantity;
                $order_id = DB::table('order_details')->insertGetId($productDetailsArr);
            }

            if ($request->payment_type == "Online") {

                $final_amt = $totalPrice - $coupon_value;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        "X-Api-Key:test_4b557b37e99399f2ccf08d3b466",
                        "X-Auth-Token:test_92b6cdf75bf5e8cc912a4de0191"
                    )
                );
                $payload = array(
                    'purpose' => 'Buy Product',
                    'amount' => $final_amt,
                    'phone' => $request->mobile,
                    'buyer_name' => $request->name,
                    'redirect_url' => 'http://127.0.0.1:8000/instamojo_payment_redirect',
                    'send_email' => true,
                    'send_sms' => true,
                    'email' => $request->email,
                    'allow_repeated_payments' => false
                );

                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
                $response = curl_exec($ch);
                curl_close($ch);

                $response = json_decode($response);

                // prx($response->payment_request->id);

                if (isset($response->payment_request->id)) {
                    $txn_id = $response->payment_request->id;
                    DB::table('orders')
                        ->where(['id' => $order_id])
                        ->update(['txn_id' => $txn_id]);

                    $payment_url = $response->payment_request->longurl;
                } else {
                    $msg = "";
                    foreach ($response->message as $key => $val) {
                        $msg .= strtoupper($key) . ": " . $val[0] . '<br/>';
                    }
                    return response()->json(['status' => 'error', 'msg' => $msg, 'payment_url' => '']);
                }
            }

            DB::table('carts')->where(['user_id' => $uid, 'user_type' => "Registered"])->delete();

            $request->session()->put('ORDER_ID', $order_id);

            $status = "success";
            $msg = "Order Placed Successfully!";
        } else {
            $status = "false";
            $msg = "Please try after sometimes.";
        }

        return response()->json(['status' => $status, 'msg' => $msg, 'payment_url' => $payment_url]);
    }

    public function order_placed(Request $request)
    {
        if ($request->session()->has('ORDER_ID')) {
            return view('frontend.order_placed');
        } else {
            return redirect('/');
        }
    }

    public function order_failed(Request $request)
    {
        if ($request->session()->has('ORDER_ID')) {
            return view('frontend.order_failed');
        } else {
            return redirect('/');
        }
    }

    public function instamojo_payment_redirect(Request $request)
    {
        if ($request->get('payment_id') !== null && $request->get('payment_status') !== null && $request->get('payment_request_id') !== null) {
            if ($request->get('payment_status') == 'Credit') {
                $status = 'Success';
                $redirect_url = '/order_placed';
            } else {
                $status = 'Failed';
                $redirect_url = '/order_failed';
            }

            $request->session()->put('ORDER_STATUS', $status);

            DB::table('orders')
                ->where(['txn_id' => $request->get('payment_request_id')])
                ->update(['payment_status' => $status, 'payment_id' => $request->get('payment_id')]);

            return redirect($redirect_url);
        } else {
            die('Something went wrong.');
        }
    }

    public function order(Request $request)
    {
        $result['orders'] =
            DB::table('orders')
            ->select('orders.*', 'order_status.order_status')
            ->leftJoin('order_status', 'order_status.id', '=', 'orders.order_status')
            ->where(['orders.customer_id' => $request->session()->get('FRONT_USER_ID')])
            ->get();

        // prx($result);

        return view('frontend.order', $result);
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
            ->where(['orders.customer_id' => $request->session()->get('FRONT_USER_ID')])
            ->get();

        if (!isset($result['order_details'][0])) {
            return redirect('/');
        }

        // prx($result);

        return view('frontend.order_details', $result);
    }

    public function product_review_process(Request $request)
    {
        // prx($_POST);

        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_ID');

            $arr = [
                "rating" => $request->rating,
                "review" => $request->review,
                "product_id" => $request->product_id,
                "status" => 1,
                "customer_id" => $uid,
                "added_on" => date('Y-m-d h:i:s')
            ];

            $query = DB::table('product_review')->insert($arr);

            $status = "success";
            $msg = "Thanks for providing your valuable review.";
        } else {
            $status = "error";
            $msg = "Please login to submit your review.";
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }
}
