<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use DomainException;
use Domains\Order\Actions\NewOrderAction;
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
			'items' => $items,
			'payments' => PaymentMethod::query()->get(),
			'deliveries' => DeliveryType::query()->get(),
		]);
	}

	// TODO: Сделать DTO, сделать абстракцию для экшена
	public function handle(OrderFormRequest $request, NewOrderAction $action)
	{
		$order = $action($request);

		return redirect()->route('home');
	}
}
