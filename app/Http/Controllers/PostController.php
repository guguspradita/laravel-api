<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;

class PostController extends Controller
{
    public function index()
    {
        // cara satu
        $posts = Post::all(); 
        // return response()->json(['pusat' => $posts]);
        return PostResource::collection($posts);

        // cara dua
        // return PostResource::collection(Post::all());
    }

    public function show($id)
    {
        $posts = Post::with('writer:id,username')->findOrFail($id);
        return new PostDetailResource($posts);
    }

}
