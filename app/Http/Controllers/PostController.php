<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        return Post::with(['user', 'likes', 'comments'])
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'music' => 'nullable|string',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'music' => $request->music,
        ]);

        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::with(['user', 'likes', 'comments'])->findOrFail($id);
        return $post;
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deletado.']);
    }
}
