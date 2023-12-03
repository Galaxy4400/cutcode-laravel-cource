<?php

namespace Domains\Order\Contracts;

use Domains\Order\Payment\PaymentData;
use Illuminate\Http\Resources\Json\JsonResource;

interface PaymentGatewayContract
{
	public function paymentId(): string;

	public function configure(array $config): void;

	public function data(PaymentData $data): self;

	public function request(): mixed;

	public function response(): JsonResource;

	public function url(): string;

	public function validate(): bool;

	public function paid(): bool;

	public function errorMessage(): string;
}
