<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function store(Request $request) 
    {
        // validasi inputan
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required'
        ]);

        // mengambil user_id dari -> user yang sudah login
        $request['user_id'] = auth()->user()->id;

        // create elequent baru ke dalam database
        $comment = Comment::create($request->all());

        // mengembalikan data berupa json
        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }

    public function update(Request $request, $id)
    {
        // validasi inputan
        $validated = $request->validate([
            'comments_content' => 'required'
        ]);

        // cari id comment pada model yang ingin di update
        $comment = Comment::findOrFail($id);

        // update eloquent dari request hanya comments_content saja
        $comment->update($request->only('comments_content'));

        // kembalikan hasil response json CommentResource beserta relationship
        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }

    public function destroy($id)
    {
        // cari id pada model comment yang ingin dihapus
        $comment = Comment::findOrFail($id);

        // lalu hapus menggunakan eloquent
        $comment->delete();

        // kembalikan hasil response json CommentResource beserta relationship
        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }
}
