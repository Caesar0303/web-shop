<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function add_favorite ($id) {
        $user_id = Auth::id();

        Favorite::create([
            'user_id' => $user_id,
            'ad_id' => $id,
        ]);

        return 200;
    }

    public function remove_favorite ($id) {
        $user_id = Auth::id();

        $fav = Favorite::where('ad_id', $id)->where('user_id', $user_id)->first();

        $fav->delete();

        return 200;
    }

    public function load_favorites() {
        $user_id = Auth::id();

        $favorites = Favorite::where('user_id',$user_id)->get();

        return json_encode($favorites);
    }
}
