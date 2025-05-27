<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar um usuário fixo pra teste manual
        $user = User::create([
            'name' => 'Wesley',
            'email' => 'wesley@example.com',
            'password' => Hash::make('12345678'),
            'avatar' => 'https://i.pravatar.cc/150?img=3'
        ]);

        // Criar outros usuários
        User::factory(5)->create();

        // Criar posts pro Wesley e outros
        $users = User::all();

        Post::factory(10)->create([
            'user_id' => $user->id
        ]);

        foreach ($users as $u) {
            Post::factory(5)->create([
                'user_id' => $u->id
            ]);
        }

        // Gerar likes e comentários aleatórios
        $posts = Post::all();

        foreach ($posts as $post) {
            // Likes
            $post->likes()->createMany(
                $users->random(rand(1, 5))->map(fn($u) => [
                    'user_id' => $u->id,
                ])->toArray()
            );

            // Comments
            $post->comments()->createMany(
                $users->random(rand(1, 4))->map(fn($u) => [
                    'user_id' => $u->id,
                    'content' => fake()->sentence(),
                ])->toArray()
            );
        }
    }
}
