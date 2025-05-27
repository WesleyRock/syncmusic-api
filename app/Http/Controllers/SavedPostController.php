<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SavedPostController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();

        $saved = $user->savedPosts()->where('post_id', $post->id)->first();

        if ($saved) {
            $saved->delete();
            return response()->json(['message' => 'Post removido dos salvos.']);
        } else {
            $user->savedPosts()->create(['post_id' => $post->id]);
            return response()->json(['message' => 'Post salvo com sucesso.']);
        }
    }

    public function index()
    {
        $savedPosts = auth()->user()->savedPosts()->with('post.user')->latest()->get();

        return $savedPosts->map(function ($saved) {
            return [
                'id' => $saved->post->id,
                'content' => $saved->post->content,
                'created_at' => $saved->post->created_at,
                'user' => [
                    'id' => $saved->post->user->id,
                    'name' => $saved->post->user->name,
                    'avatar' => $saved->post->user->avatar,
                ],
            ];
        });
    }

}
