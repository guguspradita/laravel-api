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
        // $posts = Post::with('writer:id,username')->get(); 
        // // return response()->json(['pusat' => $posts]);
        // return PostDetailResource::collection($posts);

        // cara dua
        $post = Post::all();
        return PostDetailResource::collection($post->loadMissing(['writer:id,username','comments:id,post_id,user_id,comments_content']));
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
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);
      
        // The blog post is valid...
        $post = Post::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function destroy($id)
    {
        // cari id pada model post yang ingin dihapus
        $post = Post::findOrFail($id);

        // lalu hapus menggunakan eloquent
        $post->delete();

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }
}
