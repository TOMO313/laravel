<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();
        $postId = $request->post_id;
        $alreadyLiked = Like::where('user_id', $userId)->where('post_id', $postId)->first();

        if(!$alreadyLiked){
            $like = new Like();
            $like->user_id = $userId;
            $like->post_id = $postId;
            $like->save();
        }else{
            Like::where('user_id', $userId)->where('post_id', $postId)->delete();
        }

        $post = Post::where('id', $postId)->first();
        $likesCount = $post->likes->count();

        $param = [
            'likesCount' => $likesCount,
        ];

        return response()->json($param);
    }
}
