<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SpotifyAuthController extends Controller
{
    public function redirectToSpotify()
    {
        $query = http_build_query([
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'response_type' => 'code',
            'redirect_uri' => env('SPOTIFY_REDIRECT_URI'),
            'scope' => 'user-read-playback-state user-modify-playback-state streaming',
        ]);

        return redirect("https://accounts.spotify.com/authorize?$query");
    }

    public function handleCallback(Request $request)
    {
        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => env('SPOTIFY_REDIRECT_URI'),
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
        ]);

        $data = $response->json();

        // Salva o token em sessão ou cache
        Session::put('spotify_token', $data['access_token']);

        return redirect('/')->with('success', 'Autenticado com Spotify!');
    }

    public function startPlaylist()
    {
        $token = Session::get('spotify_token');
        if (!$token) {
            return redirect()->route('spotify.login');
        }

        Http::withToken($token)->put('https://api.spotify.com/v1/me/player/play', [
            'context_uri' => 'https://open.spotify.com/playlist/2N6ujGS9n2kzRrEp6hhos1?si=e9b1bca921c34425', // Substitua pelo seu ID de playlist
        ]);

        return back()->with('success', 'Playlist iniciada!');
    }

    public function pausePlayback()
    {
        $token = Session::get('spotify_token');
        if (!$token) {
            return redirect()->route('spotify.login');
        }

        Http::withToken($token)->put('https://api.spotify.com/v1/me/player/pause');

        return back()->with('success', 'Playback pausado!');
    }

    public function ping()
    {
        $token = session('spotify_token');

        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'No access token found'], 401);
        }

        // Faz uma chamada básica à API (ex: perfil do usuário)
        $response = Http::withToken($token)->get('https://api.spotify.com/v1/me');

        if ($response->successful()) {
            return response()->json(['status' => 'ok', 'user' => $response->json()]);
        }

        return response()->json(
            [
                'status' => 'error',
                'code' => $response->status(),
                'message' => $response->json(),
            ],
            $response->status(),
        );
    }

    public function getClientCredentialsToken()
    {
        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
        ]);

        if ($response->successful()) {
            $data = $response->json();
            session(['spotify_access_token' => $data['access_token']]);

            return response()->json(['status' => 'ok', 'access_token' => $data['access_token']]);
        }

        return response()->json(['status' => 'error', 'message' => $response->body()]);
    }
}
