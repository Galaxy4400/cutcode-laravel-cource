<?php

namespace Domains\Order\Contracts;

use Closure;
use Domains\Order\Models\Order;

interface OrderProcessContract
{
	public function handle(Order $order, Closure $next);
}
