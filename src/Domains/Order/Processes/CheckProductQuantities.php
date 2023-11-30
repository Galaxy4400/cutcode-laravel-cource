<?php

namespace Domains\Order\Processes;

use Closure;
use Domains\Order\Models\Order;
use Domains\Order\Contracts\OrderProcessContract;


class CheckProductQuantities implements OrderProcessContract
{
	public function handle(Order $order, Closure $next)
	{
		// foreach ($variable as $key => $value) {
		// 	# code...
		// }
	}
}
