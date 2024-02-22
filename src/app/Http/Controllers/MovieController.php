<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'offset' => 'nullable|numeric',
            'limit' => 'nullable|numeric',
            'search' => 'nullable|string',
        ]);

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $search = $request->input('search', '');

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

        if ($search != '') {
            $movies->where('title', 'LIKE', '%' . $search . '%');
        }

        $totalMovie = $movies->count();
        $movies = $movies->offset($offset)->limit($limit);
        $moviesPageNumber = $offset >= $totalMovie ? 1 : floor($offset / $limit) + 1;

        $paginationMeta = [
            'current_page' => $moviesPageNumber,
            'last_page' => ceil($totalMovie / $limit),
            'from' => (($moviesPageNumber - 1) * $limit) + 1,
            'to' => ($moviesPageNumber * $limit) >  $totalMovie ? $totalMovie : $moviesPageNumber * $limit,
            'total' => $totalMovie,
        ];

        $data = $movies->get()
            ->map(function ($movie) {
                $movie->favorited = $movie->favorited ? true : false;
                return $movie;
            });

        return response()->json([
            'status' => 'success',
            'movies' => $data,
            'meta' => $paginationMeta,
        ]);
    }
}
