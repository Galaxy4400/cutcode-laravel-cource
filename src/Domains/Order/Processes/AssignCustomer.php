<?php

namespace Domains\Order\Processes;

use Closure;
use Domains\Order\Models\Order;
use Domains\Order\Contracts\OrderProcessContract;


class AssignCustomer implements OrderProcessContract
{

	// TODO: Лучше сделать DTO
	public function __construct(
		protected array $customerData,
	) {
	}


	public function handle(Order $order, Closure $next): Closure
	{
		$order->orderCustomer()
			->create($this->customerData);

		return $next($order);
	}
}
