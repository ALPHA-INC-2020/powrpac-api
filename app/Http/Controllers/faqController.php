<?php

namespace App\Http\Controllers;

use App\FAQ;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class faqController extends Controller
{
    public function createFAQ(Request $req)
    {
        $validatedData = $req->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $new_faq = FAQ::create([
            'question' => $validatedData['question'],
            'answer' => $validatedData['answer'],
        ]);
        return response()->json(['message' => 'success register', 'data' => $new_faq], 200);
    }

    public function getAllFAQs()
    {
        $faqs = FAQ::orderBy('created_at', 'desc')->get();
        return response()->json(['message' => 'success', 'data' => $faqs], 200);
    }

    public function deleteFAQ($id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            $faq->delete();
            return response()->json(['message' => 'delete faq success', 'data' => $faq], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'no record'], 404);
        }

    }

    public function updateFAQ(Request $req, $id)
    {

        try {
            $faq = FAQ::findOrFail($id);

            if ($req->question) {
                $faq->question = $req->question;
            }

            if ($req->answer) {
                $faq->answer = $req->answer;
            }

            $faq->save();
            return response()->json(['message' => 'update  faq success!', 'data' => $faq], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'no record'], 404);
        }

    }
}
