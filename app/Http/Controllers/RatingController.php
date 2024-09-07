<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();
        $postId = $request->postId;
        $ratingValue = $request->rating;

        $rated = Rating::where('user_id', $userId)->where('post_id', $postId)->first();

        if($rated){
            $rated->rating = $ratingValue;
            $rated->save();    
        }else{
            Rating::create([
                'user_id' => $userId,
                'post_id' => $postId,
                'rating' => $ratingValue,
            ]);
        }

        //response()->json()を使ってJSON形式でデータを返す
        return response()->json([
            'message' => '評価が保存されました！',
        ]);
    }
}
