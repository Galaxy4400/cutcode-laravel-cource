<?php

namespace Domains\Order\Payment;

use Illuminate\Support\Collection;
use Supports\ValueObjects\Price;

class PaymentData
{
	public function __construct(
		public string $id,
		public string $description,
		public string $returnUrl,
		public Price $amount,
		public Collection $meta,
	) {
	}
}
