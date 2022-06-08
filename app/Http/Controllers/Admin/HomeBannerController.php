<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class HomeBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home_banners = HomeBanner::all();
        return view('admin.home_banner.all_home_banner', ['home_banners' => $home_banners]);
    }

    public function manage_home_banner(Request $request, $home_banner_id = '')
    {
        if ($home_banner_id > 0) {
            $home_banner = HomeBanner::where(['id' => $home_banner_id])->get();
            $result['image'] = $home_banner['0']->image;
            $result['btn_text'] = $home_banner['0']->btn_text;
            $result['btn_link'] = $home_banner['0']->btn_link;
            $result['status'] = $home_banner['0']->status;
            $result['id'] = $home_banner['0']->id;
        } else {
            $result['image'] = '';
            $result['btn_text'] = '';
            $result['btn_link'] = '';
            $result['status'] = '';
            $result['id'] = 0;
        }

        return view('admin.home_banner.manage_home_banner', $result);
    }

    public function manage_home_banner_process(Request $request)
    {
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png'
        ]);

        if ($request->post('id') > 0) {
            $home_banner = HomeBanner::find($request->post('id'));
            $msg = "Home Banner has been updated successfully!";
        } else {
            $home_banner = new HomeBanner();
            $msg = "Home Banner has been created successfully!";
        }

        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->storeAs('/public/media/banner', $image_name);
            $home_banner->image = $image_name;
        }

        $home_banner->btn_text = $request->post('btn_text');
        $home_banner->btn_link = $request->post('btn_link');
        $home_banner->status = 1;
        $home_banner->save();

        $request->session()->flash('message', $msg);

        return redirect('admin/home_banner');
    }

    public function delete_home_banner(Request $request, $home_banner_id)
    {
        $arrImage = DB::table('home_banners')->where(['id' => $home_banner_id])->get();

        if (Storage::exists('/public/media/banner' . $arrImage[0]->image)) {
            Storage::delete('/public/media/banner' . $arrImage[0]->image);
        }

        $home_banner = HomeBanner::find($home_banner_id);
        $home_banner->delete();
        $request->session()->flash('message', 'Home Banner has been deleted successfully!');
        return redirect('admin/home_banner');
    }

    public function home_banner_status(Request $request, $status, $home_banner_id)
    {
        $home_banner = HomeBanner::find($home_banner_id);
        $home_banner->status = $status;
        $home_banner->save();
        $request->session()->flash('message', 'Home Banner status has been updated successfully!');
        return redirect('admin/home_banner');
    }
}
