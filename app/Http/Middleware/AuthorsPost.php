<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthorsPost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // untuk mendapatkan user yang sedang login
        $currentUser = Auth::user();
        // untuk mendapatkan postingan yang ingin di update
        $post = Post::findOrFail($request->id);

        // cek apakah user id yang sedang login tidak sama dengan postingan id
        if ($post->author != $currentUser->id) {
            return response()->json(['message' => 'data not found'], 404);
        }

        return $next($request);
    }
}
