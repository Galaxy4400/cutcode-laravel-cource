<?php

namespace Domains\Order\Actions;

use App\Http\Requests\OrderFormRequest;
use Domains\Auth\Contracts\RegisterNewUserContract;
use Domains\Auth\DTOs\NewUserDTO;
use Domains\Order\Models\Order;

class NewOrderAction
{
	// TODO: Передать данные реквеста с помощью DTO
	public function __invoke(OrderFormRequest $request): Order
	{
		$registerAction = app(RegisterNewUserContract::class);

		$customer = $request->get('customer');

		if ($request->boolean('create_account')) {
			$registerAction(NewUserDTO::make(
				sprintf('%s %s', $customer['last_name'], $customer['first_name']),
				$customer['email'],
				$request->get('password'),
			));
		}

		return Order::query()->create([
			'user_id' => auth()->id(),
			'payment_method_id' => $request->get('payment_method_id'),
			'delivery_type_id' => $request->get('delivery_type_id'),
		]);
	}
}
