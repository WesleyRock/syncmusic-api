<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
   public function index()
    {
        return Post::with('user')
            ->withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'content' => $post->content,
                    'music' => $post->music,
                    'user' => [
                        'id' => $post->user->id,
                        'name' => $post->user->name,
                        'avatar' => $post->user->avatar,
                    ],
                    'likes_count' => $post->likes_count,
                    'comments_count' => $post->comments_count,
                    'created_at' => $post->created_at,
                ];
            });
    }


    public function store(Request $request)
    {
       $request->validate([
            'content' => 'required|string|max:280',
            'music' => 'nullable|array',
            'music.nameMusic' => 'nullable|string',
            'music.nameArtist' => 'nullable|string',
            'music.image' => 'nullable|string',
            'music.colorCard' => 'nullable|string',
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:280',
        ]);

        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        $post->update([
            'content' => $request->content,
        ]);

        return response()->json(['message' => 'Post atualizado com sucesso.', 'post' => $post]);
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
