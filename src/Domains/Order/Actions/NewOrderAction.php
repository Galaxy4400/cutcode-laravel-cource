<?php

namespace Domains\Order\Actions;

use Domains\Auth\Contracts\RegisterNewUserContract;
use Domains\Auth\DTOs\NewUserDTO;
use Domains\Order\DTOs\OrderCustomerDTO;
use Domains\Order\DTOs\OrderDTO;
use Domains\Order\Models\Order;


class NewOrderAction
{
	public function __invoke(OrderDTO $order, OrderCustomerDTO $customer, bool $createAccount): Order
	{
		$registerAction = app(RegisterNewUserContract::class);

		if ($createAccount) {
			$registerAction(NewUserDTO::make(
				$customer->fullName(),
				$customer->email,
				$order->password,
			));
		}

		return Order::query()->create([
			'user_id' => auth()->id(),
			'payment_method_id' => $order->payment_method_id,
			'delivery_type_id' => $order->delivery_type_id,
		]);
	}
}
