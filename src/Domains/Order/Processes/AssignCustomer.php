<?php

namespace Domains\Order\Processes;

use Domains\Order\Models\Order;
use Domains\Order\Contracts\OrderProcessContract;
use Domains\Order\DTOs\OrderCustomerDTO;

class AssignCustomer implements OrderProcessContract
{

	public function __construct(
		protected OrderCustomerDTO $customer,
	) {
	}


	public function handle(Order $order, $next)
	{
		$order->orderCustomer()
			->create($this->customer->toArray());

		return $next($order);
	}
}
