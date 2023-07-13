<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::all();
        // return response()->json(['pusat' => $posts]);
        // // return PostResource::collection($posts);
        return PostResource::collection(Post::all());
    }
}