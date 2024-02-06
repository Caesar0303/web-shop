<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdController extends Controller
{
    public function dashboard() {
        $ads = Ad::all();
        return Inertia::render('Dashboard',['ads' => $ads]);
    }

    public function create() {
        return Inertia::render('Ad/Create');
    }

    public function store(Request $request) {
        $user_id = Auth::id();

        $paths = [];
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("img_$i")) {
                $file = $request->file("img_$i");
                $path = $file->store('images', 'public');
                $paths["img_$i"] = $path;
            }
        }

        Ad::create([
            'author_id' => $user_id,
            'category_id' => 1,
            'city_id' => 1,
            'header' => $request->header,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'views' => 0,
            'img_1' => $paths['img_1'] ?? null,
            'img_2' => $paths['img_2'] ?? null,
            'img_3' => $paths['img_3'] ?? null,
        ]);

        return 200;
    }

    public function show ($id) {
        $user_id = Auth::id();

        $ad = Ad::find($id);
        $cart = Cart::where('user_id',$user_id)->where('ad_id',$id)->first();
        if (isset($cart)) {
            $added = true;
        } else {
            $added = false;
        }

        return Inertia::render('Ad/Show',['ad' => $ad, 'added' => $added]);
    }

    public function edit ($id) {
        $ad = Ad::find($id);
        return Inertia::render('Ad/Edit',['ad' => $ad]);
    }

    public function update($id, Request $request) {
        $ad = Ad::find($id);
        if (!$ad) {
            return response()->json(['error' => 'Ad not found'], 404);
        }
        $user_id = Auth::id();

        $paths = [];
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("img_$i")) {
                $file = $request->file("img_$i");
                $path = $file->store('images', 'public');
                $paths["img_$i"] = $path;
            } else {
                // For images not being updated, keep the current path
                $paths["img_$i"] = $ad->{"img_$i"};
            }
        }

        $ad->update([
            'author_id' => $user_id,
            'category_id' => $request->input('category_id', 1),
            'city_id' => $request->input('city_id', 1),
            'header' => $request->header,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'views' => $ad->views,
            'img_1' => $paths['img_1'],
            'img_2' => $paths['img_2'],
            'img_3' => $paths['img_3'],
        ]);

        return 200;
    }

    public function delete($id) {
        $ad = Ad::find($id);

        $ad->delete();

        return 200;
    }
}
