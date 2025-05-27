<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $user = auth()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Post já curtido.'], 409);
        }

        $post->likes()->create([
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Curtido com sucesso!']);
    }

    public function unlike(Post $post)
    {
        $user = auth()->user();

        $post->likes()->where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Descurtido com sucesso!']);
    }
}
