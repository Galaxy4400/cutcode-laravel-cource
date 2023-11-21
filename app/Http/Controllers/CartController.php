<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Domains\Product\Models\Product;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Domains\Cart\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class CartController extends Controller
{

	public function index(): View|Factory
	{
		return view('cart.index', [
			'items' => cart()->items(),
		]);
	}


	public function add(Product $product): RedirectResponse
	{
		cart()->add($product, request('quantity', 1), request('options', []));

		flash()->info('Товар добавлен в корзину');

		return redirect()->intended(route('cart'));
	}


	public function quantity(CartItem $item): RedirectResponse
	{
		cart()->quantity($item, request('quantity', 1));

		flash()->info('Количество товаров изменено');

		return redirect()->intended(route('cart'));
	}


	public function delete(CartItem $item): RedirectResponse
	{
		cart()->delete($item);

		flash()->info('Удалено из корзины');

		return redirect()->intended(route('cart'));
	}


	public function truncate(): RedirectResponse
	{
		cart()->truncate();

		flash()->info('Корзина очищена');

		return redirect()->intended(route('cart'));
	}
}
