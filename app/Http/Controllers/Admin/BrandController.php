<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brand.all_brand', ['brands' => $brands]);
    }

    public function manage_brand(Request $request, $brand_id = '')
    {
        if ($brand_id > 0) {
            $brand = Brand::where(['id' => $brand_id])->get();
            $result['name'] = $brand['0']->name;
            $result['image'] = $brand['0']->image;
            $result['status'] = $brand['0']->status;
            $result['id'] = $brand['0']->id;

            $result['is_home'] = $brand['0']->is_home;

            $result['is_home_selected'] = '';

            if ($brand['0']->is_home == 1) {
                $result['is_home_selected'] = 'checked';
            }
        } else {
            $result['name'] = '';
            $result['image'] = '';
            $result['status'] = '';
            $result['id'] = 0;

            $result['is_home'] = '';

            $result['is_home_selected'] = '';
        }

        return view('admin.brand.manage_brand', $result);
    }

    public function manage_brand_process(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,' . $request->post('id'),
            'image' => 'mimes:jpeg,jpg,png'
        ]);

        if ($request->post('id') > 0) {
            $brand = Brand::find($request->post('id'));
            $msg = "Brand has been updated successfully!";
        } else {
            $brand = new Brand();
            $msg = "Brand has been created successfully!";
        }

        if ($request->hasfile('image')) {

            if ($request->post('id') > 0) {
                $arrImage = DB::table('brands')->where(['id' => $request->post('id')])->get();
                if (Storage::exists('/public/media/brand/' . $arrImage[0]->image)) {
                    Storage::delete('/public/media/brand/' . $arrImage[0]->image);
                }
            }

            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->storeAs('/public/media/brand', $image_name);
            $brand->image = $image_name;
        }

        $brand->is_home = 0;

        if ($request->post('is_home') !== null) {

            $brand->is_home = 1;
        }

        $brand->name = $request->post('name');
        $brand->status = 1;
        $brand->save();

        $request->session()->flash('message', $msg);

        return redirect('admin/brand');
    }

    public function delete_brand(Request $request, $brand_id)
    {
        $arrImage = DB::table('product_attrs')->where(['id' => $brand_id])->get();

        if (Storage::exists('/public/media/brand' . $arrImage[0]->image)) {
            Storage::delete('/public/media/brand' . $arrImage[0]->image);
        }

        $brand = Brand::find($brand_id);
        $brand->delete();
        $request->session()->flash('message', 'Brand has been deleted successfully!');
        return redirect('admin/brand');
    }

    public function brand_status(Request $request, $status, $brand_id)
    {
        $brand = Brand::find($brand_id);
        $brand->status = $status;
        $brand->save();
        $request->session()->flash('message', 'Brand status has been updated successfully!');
        return redirect('admin/brand');
    }
}
