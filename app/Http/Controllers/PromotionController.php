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
            'images' => 'required',
        ]);

        $promotion = Promotion::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'images' => $validatedData['images'],
        ]);
        return response($promotion, 200);
    }

    public function getAllPromotions()
    {
        return response(Promotion::orderBy('status', 'desc')->get(), 200);
    }
}
