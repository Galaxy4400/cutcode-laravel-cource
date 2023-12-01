<?php

namespace Domains\Order\Processes;

use Closure;
use Domains\Order\Models\Order;
use Domains\Order\Contracts\OrderProcessContract;


class ClearCart implements OrderProcessContract
{
	public function handle(Order $order, Closure $next): Closure
	{
		cart()->truncate();

		return $next($order);
	}
}
