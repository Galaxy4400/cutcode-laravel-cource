<?php

namespace Domains\Order\Payment\Gateways;

use Domains\Order\Contracts\PaymentGatewayContract;


class YooKassa implements PaymentGatewayContract
{
	
	public function paymentId(): string
	{

	}


	public function configure(array $config): void
	{

	}


	public function data(PaymentData $data): self
	{

	}


	public function request(): mixed
	{

	}


	public function response(): JsonResource
	{

	}


	public function url(): string
	{

	}


	public function validate(): bool
	{

	}


	public function paid(): bool
	{

	}


	public function errorMessage(): string
	{

	}
}

