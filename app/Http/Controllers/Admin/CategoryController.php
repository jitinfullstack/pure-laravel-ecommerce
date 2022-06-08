<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.all_category', ['categories' => $categories]);
    }

    public function manage_category(Request $request, $category_id = '')
    {
        if ($category_id > 0) {
            $category = Category::where(['id' => $category_id])->get();
            $result['category_name'] = $category['0']->category_name;
            $result['category_slug'] = $category['0']->category_slug;

            $result['parent_category_id'] = $category['0']->parent_category_id;
            $result['category_image'] = $category['0']->category_image;

            $result['is_home'] = $category['0']->is_home;

            $result['is_home_selected'] = '';

            if ($category['0']->is_home == 1) {
                $result['is_home_selected'] = 'checked';
            }

            $result['id'] = $category['0']->id;

            $result['category'] = DB::table('categories')->where(['status' => 1])->where('id', '!=', $category_id)->get();
        } else {
            $result['category_name'] = '';
            $result['category_slug'] = '';

            $result['parent_category_id'] = '';
            $result['category_image'] = '';

            $result['is_home'] = '';

            $result['is_home_selected'] = '';

            $result['id'] = 0;

            $result['category'] = DB::table('categories')->where(['status' => 1])->get();
        }



        return view('admin.category.manage_category', $result);
    }

    public function manage_category_process(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'category_image' => 'mimes:jpeg,jpg,png',
            'category_slug' => 'required|unique:categories,category_slug,' . $request->post('id')
        ]);

        if ($request->post('id') > 0) {
            $category = Category::find($request->post('id'));
            $msg = "Category has been updated successfully!";
        } else {
            $category = new Category();
            $msg = "Category has been created successfully!";
        }

        $category->category_name = $request->post('category_name');
        $category->category_slug = $request->post('category_slug');

        $category->parent_category_id = $request->post('parent_category_id');
        //$category->category_image = $request->post('category_image');

        if ($request->hasfile('category_image')) {

            if ($request->post('id') > 0) {
                $arrImage = DB::table('categories')->where(['id' => $request->post('id')])->get();
                if (Storage::exists('/public/media/category/' . $arrImage[0]->category_image)) {
                    Storage::delete('/public/media/category/' . $arrImage[0]->category_image);
                }
            }

            $image = $request->file('category_image');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->storeAs('/public/media/category', $image_name);
            $category->category_image = $image_name;
        }

        $category->is_home = 0;

        if ($request->post('is_home') !== null) {

            $category->is_home = 1;
        }

        $category->status = 1;
        $category->save();

        $request->session()->flash('message', $msg);

        return redirect('admin/category');
    }

    public function delete_category(Request $request, $category_id)
    {
        $arrImage = DB::table('categories')->where(['id' => $category_id])->get();

        if (Storage::exists('/public/media/category' . $arrImage[0]->category_image)) {
            Storage::delete('/public/media/category' . $arrImage[0]->category_image);
        }

        $category = Category::find($category_id);
        $category->delete();
        $request->session()->flash('message', 'Category has been deleted successfully!');
        return redirect('admin/category');
    }

    public function category_status(Request $request, $status, $category_id)
    {
        $category = Category::find($category_id);
        $category->status = $status;
        $category->save();
        $request->session()->flash('message', 'Category status has been updated successfully!');
        return redirect('admin/category');
    }
}
