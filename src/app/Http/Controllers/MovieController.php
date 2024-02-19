<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::select('movies.*');
        $user = Auth::user();
        if ($user) {
            $favorited = Favorites::select('id')
                ->whereColumn('favorites.movie_id', 'movies.id')
                ->where('favorites.user_id', $user->id)
                ->limit(1)
                ->getQuery();
            $movies->selectSub($favorited, 'favorited');
        }
        $data = $movies->get()
            ->map(function ($movie) {
                $movie->favorited = $movie->favorited ? true : false;
                return $movie;
            });
        return response()->json([
            'status' => 'success',
            'movies' => $data,
        ]);
    }
}
