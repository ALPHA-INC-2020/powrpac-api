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
            'status' => 'required',
            'images' => 'required',
        ]);

        $new_banner = Banner::create([
            'name' => $validatedData['name'],
            'banner_title' => $validatedData['banner_title'],
            'status' => $validatedData['status'],
            'images' => $validatedData['images'],
        ]);

        return response($new_banner, 200)->header('Content-Type', 'application/json');
    }

    public function setActiveBanner(Request $req, $id)
    {
        $banner = Banner::find($id);

        $banner->status = $req->status;

        $banner->save();
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
}
