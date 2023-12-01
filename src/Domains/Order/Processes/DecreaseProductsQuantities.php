<?php

namespace Domains\Order\Processes;

use Domains\Order\Models\Order;
use Domains\Order\Contracts\OrderProcessContract;
use Illuminate\Support\Facades\DB;

class DecreaseProductsQuantities implements OrderProcessContract
{
	public function handle(Order $order, $next)
	{
		foreach (cart()->items() as $item) {
			$item->product()->update([
				'quantity' => DB::raw("quantity - {$item->quantity}")
			]);
		}

		return $next($order);
	}
}
