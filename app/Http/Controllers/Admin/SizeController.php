<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::all();
        return view('admin.size.all_size', ['sizes' => $sizes]);
    }

    public function manage_size(Request $request, $size_id = '')
    {
        if ($size_id > 0) {
            $size = Size::where(['id' => $size_id])->get();
            $result['size'] = $size['0']->size;
            $result['id'] = $size['0']->id;
        } else {
            $result['size'] = '';
            $result['id'] = 0;
        }

        return view('admin.size.manage_size', $result);
    }

    public function manage_size_process(Request $request)
    {
        $request->validate([
            'size' => 'required|unique:sizes,size,' . $request->post('id'),
        ]);

        if ($request->post('id') > 0) {
            $size = Size::find($request->post('id'));
            $msg = "Size has been updated successfully!";
        } else {
            $size = new Size();
            $msg = "Size has been created successfully!";
        }

        $size->size = $request->post('size');
        $size->status = 1;
        $size->save();

        $request->session()->flash('message', $msg);

        return redirect('admin/size');
    }

    public function delete_size(Request $request, $size_id)
    {
        $size = Size::find($size_id);
        $size->delete();
        $request->session()->flash('message', 'Size has been deleted successfully!');
        return redirect('admin/size');
    }

    public function size_status(Request $request, $status, $size_id)
    {
        $size = Size::find($size_id);
        $size->status = $status;
        $size->save();
        $request->session()->flash('message', 'Size status has been updated successfully!');
        return redirect('admin/size');
    }
}
