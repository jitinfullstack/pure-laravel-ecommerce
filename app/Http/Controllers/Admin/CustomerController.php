<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer.all_customer', ['customers' => $customers]);
    }

    public function show(Request $request, $customer_id = '')
    {
        $customer = Customer::where(['id' => $customer_id])->get();

        $result['customer_list'] = $customer['0'];

        // dd($result['customer_list']);

        return view('admin.customer.show_customer', $result);
    }

    public function customer_status(Request $request, $status, $customer_id)
    {
        $customer = Customer::find($customer_id);
        $customer->status = $status;
        $customer->save();
        $request->session()->flash('message', 'Customer status has been updated successfully!');
        return redirect('admin/customer');
    }
}
