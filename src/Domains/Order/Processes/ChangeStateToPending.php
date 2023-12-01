<?php

namespace Domains\Order\Processes;

use Closure;
use Domains\Order\Models\Order;
use Domains\Order\Contracts\OrderProcessContract;
use Domains\Order\States\PendingOrderState;

class ChangeStateToPending implements OrderProcessContract
{
	public function handle(Order $order, Closure $next): Closure
	{
		$order->status->transitionTo(new PendingOrderState($order));

		return $next($order);
	}
}
