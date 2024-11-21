<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(3);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);        
    }
}
