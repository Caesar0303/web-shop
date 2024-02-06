<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    public function list() {
        $user_id = Auth::id();

        // Загружаем записи корзины и связанные с ними объявления для текущего пользователя
        $items = Cart::where('user_id', $user_id)->with('ad')->get();

        // Используем pluck для извлечения всех объявлений из коллекции items
        // Это создаст коллекцию всех связанных моделей ad
        $ads = $items->pluck('ad')->filter();

        // Возвращаем представление с объявлениями
        return Inertia::render('Cart/Cart', ['ads' => $ads]);
    }
    public function add_to_cart($id) {
        $user_id = Auth::id();

        Cart::create([
           'user_id' => $user_id,
           'ad_id' => $id,
        ]);

        return 200;
    }

    public function remove_from_cart($id) {
        $user_id = Auth::id();

        $cart = Cart::where('ad_id', $id)->where('user_id', $user_id)->first();

        $cart->delete();

        return 200;
    }
}
