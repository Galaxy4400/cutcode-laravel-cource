<?php

namespace App\Events;

use Domains\Order\Models\Order;
use Domains\Order\States\OrderState;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;


class OrderStatusChanged
{
	use Dispatchable, InteractsWithSockets, SerializesModels;


	public function __construct(
		public Order $order,
		public OrderState $old,
		public OrderState $current,
	) {
	}

}
