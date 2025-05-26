<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $like = Like::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        return response()->json(['message' => 'Post curtido.', 'like' => $like]);
    }

    public function unlike(Post $post)
    {
        $deleted = Like::where('user_id', Auth::id())
                        ->where('post_id', $post->id)
                        ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Curtida removida.']);
        }

        return response()->json(['message' => 'Você não tinha curtido esse post.']);
    }
}
