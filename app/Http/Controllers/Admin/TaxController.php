<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxes = Tax::all();
        return view('admin.tax.all_tax', ['taxes' => $taxes]);
    }

    public function manage_tax(Request $request, $tax_id = '')
    {
        if ($tax_id > 0) {
            $tax = Tax::where(['id' => $tax_id])->get();
            $result['tax_description'] = $tax['0']->tax_description;
            $result['tax_value'] = $tax['0']->tax_value;
            $result['id'] = $tax['0']->id;
        } else {
            $result['tax_description'] = '';
            $result['tax_value'] = '';
            $result['id'] = 0;
        }

        return view('admin.tax.manage_tax', $result);
    }

    public function manage_tax_process(Request $request)
    {
        $request->validate([
            'tax_value' => 'required|unique:taxes,tax_value,' . $request->post('id'),
            'tax_description' => 'required'
        ]);

        if ($request->post('id') > 0) {
            $tax = Tax::find($request->post('id'));
            $msg = "Tax has been updated successfully!";
        } else {
            $tax = new Tax();
            $msg = "Tax has been created successfully!";
        }

        $tax->tax_description = $request->post('tax_description');
        $tax->tax_value = $request->post('tax_value');
        $tax->status = 1;
        $tax->save();

        $request->session()->flash('message', $msg);

        return redirect('admin/tax');
    }

    public function delete_tax(Request $request, $tax_id)
    {
        $tax = Tax::find($tax_id);
        $tax->delete();
        $request->session()->flash('message', 'Tax has been deleted successfully!');
        return redirect('admin/tax');
    }

    public function tax_status(Request $request, $status, $tax_id)
    {
        $tax = Tax::find($tax_id);
        $tax->status = $status;
        $tax->save();
        $request->session()->flash('message', 'Tax status has been updated successfully!');
        return redirect('admin/tax');
    }
}
