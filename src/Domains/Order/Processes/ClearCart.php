<?php

namespace Domains\Order\Processes;

use Domains\Order\Models\Order;
use Domains\Order\Contracts\OrderProcessContract;


class ClearCart implements OrderProcessContract
{
	public function handle(Order $order, $next)
	{
		cart()->truncate();

		return $next($order);
	}
}
