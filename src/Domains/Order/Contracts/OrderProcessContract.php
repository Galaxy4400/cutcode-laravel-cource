<?php

namespace Domains\Order\Contracts;

use Domains\Order\Models\Order;

interface OrderProcessContract
{
	public function handle(Order $order, $next);
}
