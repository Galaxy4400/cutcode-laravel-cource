<?php

namespace Domains\Order\Enums;

use Domains\Order\Models\Order;
use Domains\Order\States\OrderState;
use Domains\Order\States\NewOrderState;
use Domains\Order\States\PaidOrderState;
use Domains\Order\States\PendingOrderState;
use Domains\Order\States\CancelledOrderState;

enum OrderStatuses: string
{
	case New = 'new';
	case Pending = 'pending';
	case Paid = 'paid';
	case Cancelled = 'cancelled';


	public function createState(Order $order): OrderState
	{
		return match ($this) {
			OrderStatuses::New => new NewOrderState($order),
			OrderStatuses::Pending => new PendingOrderState($order),
			OrderStatuses::Paid => new PaidOrderState($order),
			OrderStatuses::Cancelled => new CancelledOrderState($order),
		};
	}
}
