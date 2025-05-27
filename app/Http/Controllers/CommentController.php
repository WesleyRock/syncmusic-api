<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
   public function index(Post $post)
    {
        $comments = $post->comments()->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($comments);
    }

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Comentário criado com sucesso!',
            'comment' => $comment->load('user')
        ], 201);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comentário deletado.']);
    }
}
