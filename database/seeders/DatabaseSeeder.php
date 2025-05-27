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
        // meu usuário
        $mainUser = User::firstOrCreate(
            ['email' => 'wesley@example.com'],
            [
                'name' => 'Wesley',
                'password' => Hash::make('12345678'),
                'avatar' => 'https://i.pravatar.cc/150?img=3'
            ]
        );

        // cria usuários aleatórios
        $users = User::factory(5)->create();
        $users->push($mainUser);

        //cria posts fixos com músicas
        $musics = [
            [
                'nameMusic' => 'Pecado Capital',
                'nameArtist' => 'Xamã',
                'image' => 'https://i.pinimg.com/736x/e0/30/87/e0308750fc6286a12dea2bbd167981d6.jpg',
                'colorCard' => '#952175',
            ],
            [
                'nameMusic' => 'Marília Mendonça - Ao vivo',
                'nameArtist' => 'Marília Mendonça',
                'image' => 'https://i.pinimg.com/736x/7a/e6/3c/7ae63c03616acee1d01e52ea9b48c906.jpg',
                'colorCard' => '#342e7b',
            ],
            [
                'nameMusic' => 'Clube da Esquina',
                'nameArtist' => 'Lô Borge e Milton Nascimento',
                'image' => 'https://i.pinimg.com/736x/c5/12/8e/c5128e11e158a39bd38fa0f5cfb65661.jpg',
                'colorCard' => '#342e7b',
            ],
            [
                'nameMusic' => 'Short n Sweet',
                'nameArtist' => 'Sabrina Carpenter',
                'image' => 'https://i.pinimg.com/736x/ab/43/04/ab43048b671d7de6590d91627422d69f.jpg',
                'colorCard' => '#234c9e',
            ],
            [
                'nameMusic' => 'The Laws of Scourge',
                'nameArtist' => 'Sarcófacgo',
                'image' => 'https://i.pinimg.com/736x/3d/80/b9/3d80b941218f367b53dbdc1d4b621111.jpg',
                'colorCard' => '#082a97',
            ],
        ];

        foreach ($users as $user) {
            foreach ($musics as $music) {
                Post::create([
                    'user_id' => $user->id,
                    'content' => 'Post sobre a música ' . $music['nameMusic'],
                    'music' => $music,
                ]);
            }
        }

        // isso aq eh pra gerar likes e comentários aleatórios para todos os posts
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

        $this->command->info('Seed executado com sucesso: usuários, posts, músicas, likes e comentários gerados!');
    }
}
