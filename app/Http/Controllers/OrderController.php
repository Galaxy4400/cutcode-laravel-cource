<?php

namespace App\Http\Controllers;

use DomainException;
use Domains\Order\Models\DeliveryType;
use Domains\Order\Models\PaymentMethod;

class OrderController extends Controller
{
	public function index()
	{
		$items = cart()->items();

		if ($items->isEmpty()) {
			throw new DomainException('Корзина пуста');
		}

		return view('order.index', [
			'item' => $items,
			'payment' => PaymentMethod::query()->get(),
			'payment' => DeliveryType::query()->get(),
		]);
	}


	public function handle()
	{

	}
}
