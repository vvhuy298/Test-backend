<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorites;
use App\Models\Movie;
use DB;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(string $uuid, string $type)
    {
        $user = Auth::user();
        $movie = Movie::findByUuid($uuid);
        switch ($type) {
            case 'favorite':
                DB::beginTransaction();
                try {
                    Favorites::create([
                        'movie_id' => $movie->id,
                        'user_id' => $user->id,
                    ]);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                }
                break;
            case 'unfavorite':
                DB::beginTransaction();
                try {
                    Favorites::where([
                        ['movie_id', '=', $movie->id],
                        ['user_id', '=', $user->id],
                    ])->delete();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                }
                break;
            default:
                break;
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'movie_id' => $movie->id,
                'user_id' => $user->id,
            ]
        ]);
    }
}
