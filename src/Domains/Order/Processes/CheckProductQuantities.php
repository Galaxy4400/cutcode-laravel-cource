<?php

namespace Domains\Order\Processes;

use Closure;
use Domains\Order\Models\Order;
use Domains\Order\Contracts\OrderProcessContract;
use Domains\Order\Exceptions\OrderProcessException;

class CheckProductQuantities implements OrderProcessContract
{
	public function handle(Order $order, Closure $next): Closure
	{
		foreach (cart()->items() as $item) {
			if ($item->product->quantity < $item->quantity) {
				throw new OrderProcessException('Не осталось товара');
			}
		}

		return $next($order);
	}
}
