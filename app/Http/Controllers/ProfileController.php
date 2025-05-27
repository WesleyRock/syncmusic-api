<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
{
    return $request->user()->load('posts');
}

public function update(Request $request)
{
    $data = $request->validate([
        'name' => 'string|max:255',
        'email' => 'email|max:255',
        'description' => 'nullable|string|max:500',
    ]);

    $user = $request->user();
    $user->update($data);

    return response()->json(['message' => 'Perfil atualizado com sucesso!', 'user' => $user]);
}
}
