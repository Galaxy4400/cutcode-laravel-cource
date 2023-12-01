<?php

namespace Domains\Order\Processes;

use Closure;
use Domains\Order\Models\Order;
use Domains\Order\Contracts\OrderProcessContract;


class AssignProducts implements OrderProcessContract
{
	public function handle(Order $order, Closure $next): Closure
	{
		$order->orderItems()
			->createMany(
				cart()->items()->map(fn ($item) => [
					'product_id' => $item->product_id,
					'price' => $item->price,
					'quantity' => $item->quantity,
				])->toArray()
			);

		return $next($order);
	}
}
