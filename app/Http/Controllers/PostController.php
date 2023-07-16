<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostDetailResource;

class PostController extends Controller
{
    public function index()
    {
        // cara satu
        $posts = Post::with('writer:id,username')->get(); 
        // return response()->json(['pusat' => $posts]);
        return PostDetailResource::collection($posts);

        // cara dua
        // return PostResource::collection(Post::all());
    }

    public function show($id)
    {
        $posts = Post::with('writer:id,username')->findOrFail($id);
        return new PostDetailResource($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);
     
        // The blog post is valid...

        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function update(Request $request, $id)
    {
        // $validated = $request->validate([
        //     'title' => 'required|max:255',
        //     'news_content' => 'required',
        // ]);
     
        // The blog post is valid...

        
    }
}
