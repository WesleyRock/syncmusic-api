<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    /**
     * Buscar músicas no Spotify
     */
    public function search(Request $request)
    {
        $query = $request->query('q');

        if (!$query) {
            return response()->json(['error' => 'Query é obrigatória'], 400);
        }

        $token = $this->getSpotifyToken();

        $response = Http::withToken($token)
            ->get('https://api.spotify.com/v1/search', [
                'q' => $query,
                'type' => 'track',
                'limit' => 5,
            ]);

        return $response->json();
    }

    /**
     * Gerar token do Spotify
     */
    private function getSpotifyToken()
    {
        $clientId = config('services.spotify.client_id');
        $clientSecret = config('services.spotify.client_secret');

        $response = Http::asForm()
            ->withBasicAuth($clientId, $clientSecret)
            ->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            abort(500, 'Erro ao obter token do Spotify');
        }

        return $response->json()['access_token'];
    }
}
