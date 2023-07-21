<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikKomentar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user(); // tampung untuk mendapatkan user yang sedang login

        // cari comment yang ingin di update pada model comment
        $comment = Comment::findOrFail($request->id);

        // cek apakah comment user id valid dengan user yg sedang login
        if ($comment->user_id != $user->id) {
            return response()->json(['message' => 'data not found'], 404);
        }
        return $next($request);
    }
}
