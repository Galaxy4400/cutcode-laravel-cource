<?php

namespace Domains\Order\DTOs;

use Supports\Traits\Makeable;


/**
 * @method static static make(int $payment_method_id, int $delivery_type_id, string $password)
 */
class OrderDTO
{
	use Makeable;

	public function __construct(
		public readonly int $payment_method_id,
		public readonly int $delivery_type_id,
		public readonly string $password,
	) {
	}
}
