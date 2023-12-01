<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use DomainException;
use Domains\Order\Actions\NewOrderAction;
use Domains\Order\Models\DeliveryType;
use Domains\Order\Models\PaymentMethod;
use Domains\Order\Processes\AssignCustomer;
use Domains\Order\Processes\AssignProducts;
use Domains\Order\Processes\ChangeStateToPending;
use Domains\Order\Processes\CheckProductQuantities;
use Domains\Order\Processes\ClearCart;
use Domains\Order\Processes\DecreaseProductsQuantities;
use Domains\Order\Processes\OrderProcess;

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
	public function handle(OrderFormRequest $request, NewOrderAction $newOrderAction)
	{
		$order = $newOrderAction($request);

		(new OrderProcess($order))->processes([
			new CheckProductQuantities(),
			new AssignCustomer(request('customer')),
			new AssignProducts(),
			new ChangeStateToPending(),
			new DecreaseProductsQuantities(),
			new ClearCart(),
		])->run();

		return redirect()->route('home');
	}
}
