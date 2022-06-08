<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::all();
        return view('admin.color.all_color', ['colors' => $colors]);
    }

    public function manage_color(Request $request, $color_id = '')
    {
        if ($color_id > 0) {
            $color = Color::where(['id' => $color_id])->get();
            $result['color'] = $color['0']->color;
            $result['id'] = $color['0']->id;
        } else {
            $result['color'] = '';
            $result['id'] = 0;
        }

        return view('admin.color.manage_color', $result);
    }

    public function manage_color_process(Request $request)
    {
        $request->validate([
            'color' => 'required|unique:colors,color,' . $request->post('id'),
        ]);

        if ($request->post('id') > 0) {
            $color = Color::find($request->post('id'));
            $msg = "Color has been updated successfully!";
        } else {
            $color = new Color();
            $msg = "Color has been created successfully!";
        }

        $color->color = $request->post('color');
        $color->status = 1;
        $color->save();

        $request->session()->flash('message', $msg);

        return redirect('admin/color');
    }

    public function delete_color(Request $request, $color_id)
    {
        $color = Color::find($color_id);
        $color->delete();
        $request->session()->flash('message', 'Color has been deleted successfully!');
        return redirect('admin/color');
    }

    public function color_status(Request $request, $status, $color_id)
    {
        $color = Color::find($color_id);
        $color->status = $status;
        $color->save();
        $request->session()->flash('message', 'Color status has been updated successfully!');
        return redirect('admin/color');
    }
}
