<?php

namespace Domains\Order\States\Payment;


class CancelledPaymentState extends PaymentState
{
	public static string $name = 'cancelled';
}
