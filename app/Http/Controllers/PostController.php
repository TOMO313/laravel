<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index()
    {
        $success_login_message = Cache::pull('success_login_message'); //pull()はキャッシュから取得した後に削除。

        $posts = Post::orderBy('created_at', 'desc')->paginate(3);

        return view('posts.index', compact('posts', 'success_login_message'));
    }

    public function show(Post $post)
    {
        dd($post);
        return view('posts.show')->with(['post' => $post]);
    }

    public function apiIndex()
    {
        $posts = Post::all();
        return PostResource::collection($posts); //response()->json()を使用しなくても、PostResource::collection()を使用すれば、PostResourceで指定した形でJSON形式に変換できる。
    }
}
