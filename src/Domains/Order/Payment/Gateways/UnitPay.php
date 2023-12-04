<?php

namespace Domains\Order\Payment\Gateways;

use Domains\Order\Payment\PaymentData;
use Illuminate\Http\Resources\Json\JsonResource;
use Domains\Order\Contracts\PaymentGatewayContract;


class UnitPay implements PaymentGatewayContract
{
	
	public function paymentId(): string
	{
		return 'unitpay';
	}


	public function configure(array $config): void
	{

	}


	public function data(PaymentData $data): self
	{
		return $this;
	}


	public function request(): mixed
	{
		
	}


	public function response(): JsonResource
	{
		return new JsonResource('resource');
	}


	public function url(): string
	{
		return '';
	}


	public function validate(): bool
	{
		return true;
	}


	public function paid(): bool
	{
		return true;
	}


	public function errorMessage(): string
	{
		return 'error';
	}
}

