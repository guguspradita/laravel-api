<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required'
        ]);

        // mengambil user_id dari -> user yang sudah login
        $request['user_id'] = auth()->user()->id;

        // create elequent baru ke dalam database
        $comment = Comment::create($request->all());

        // mengembalikan data berupa json
        return response()->json($comment->loadMissing(['commentator']));
    }
}
