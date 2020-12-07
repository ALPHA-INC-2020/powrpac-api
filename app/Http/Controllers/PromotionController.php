<?php

namespace App\Http\Controllers;

use App\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function createNewPromotion(Request $res)
    {
        $validatedData = $res->validate([
            'title' => 'required',
            'content' => 'required',
            'imageURLs' => 'required',
        ]);

        $promotion = Promotion::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'imageURLs' => $validatedData['imageURLs'],
        ]);
        return response($promotion, 200);
    }

    public function setActivePromotion(Request $res, $id)
    {

        $to_active_promotion = Promotion::findOrFail($id);
        $to_active_promotion->status = !$res->status;
        $to_active_promotion->save();

        return response(Promotion::orderBy('status', 'desc')->get(), 200);
    }

    public function getAllPromotions()
    {
        return response(Promotion::orderBy('status', 'desc')->get(), 200);
    }

    public function getAllActivePromotions()
    {
        return response(Promotion::where('status', true)->get(), 200);
    }

    public function deletePromotion($id)
    {
        $promotion = Promotion::find($id);
        $promotion->delete();
        return response($promotion, 200)->header('Content-Type', 'application/json');
    }
}
