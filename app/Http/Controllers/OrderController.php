<?php

namespace App\Http\Controllers;

use DomainException;
use Domains\Order\Models\DeliveryType;
use Domains\Order\Processes\ClearCart;
use App\Http\Requests\OrderFormRequest;
use Domains\Order\Models\PaymentMethod;
use Domains\Order\Actions\NewOrderAction;
use Domains\Order\DTOs\OrderCustomerDTO;
use Domains\Order\DTOs\OrderDTO;
use Domains\Order\Processes\OrderProcess;
use Domains\Order\Processes\AssignCustomer;
use Domains\Order\Processes\AssignProducts;
use Domains\Order\Processes\ChangeStateToPending;
use Domains\Order\Processes\CheckProductQuantities;
use Domains\Order\Processes\DecreaseProductsQuantities;

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
		$order = $newOrderAction(
			OrderDTO::make($request->only(['payment_method_id', 'delivery_type_id', 'password'])),
			OrderCustomerDTO::fromArray($request->get('customer')),
			$request->boolean('create_account'),
		);

		(new OrderProcess($order))->processes([
			new CheckProductQuantities(),
			new AssignCustomer(OrderCustomerDTO::fromArray($request->get('customer'))),
			new AssignProducts(),
			new ChangeStateToPending(),
			new DecreaseProductsQuantities(),
			new ClearCart(),
		])->run();

		return redirect()->route('home');
	}
}
