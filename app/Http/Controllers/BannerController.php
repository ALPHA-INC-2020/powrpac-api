<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function createNewBanner(Request $req)
    {
        $validatedData = $req->validate([
            'name' => 'required',
            'banner_title' => 'required',
            'image' => 'required',
        ]);

        $new_banner = Banner::create([
            'name' => $validatedData['name'],
            'banner_title' => $validatedData['banner_title'],
            'image' => $validatedData['image'],
        ]);

        return response($new_banner, 200)->header('Content-Type', 'application/json');
    }

    public function setActiveBanner(Request $req, $id)
    {
        $banner = Banner::all();
        $active_banner = $banner->where('status', true)->first();
        if (isset($active_banner)) {
            $active_banner->status = false;
            $active_banner->save();
        }
        $to_active_banner = $banner->find($id);
        $to_active_banner->status = true;

        $to_active_banner->save();
        return response(Banner::orderBy('status', 'desc')->get(), 200);
    }

    public function getActiveBanner()
    {
        $active_banner = Banner::where('status', true)->first();

        return response($active_banner, 200)->header('Content-Type', 'applicatoin/json');
    }

    public function getAllBanners()
    {
        return response(Banner::orderBy('status', 'desc')->get(), 200)->header('Content-Type', 'application/json');
    }

    public function deleteBanner($id)
    {
        $banner = Banner::find($id);
        $banner->delete();
        return response($banner, 200)->header('Content-Type', 'application/json');
    }
}
