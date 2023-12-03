<?php

namespace Domains\Order\Providers;

use Domains\Order\Models\Payment;
use Domains\Order\Payment\Gateways\YooKassa;
use Domains\Order\Payment\PaymentData;
use Illuminate\Support\ServiceProvider;
use Domains\Order\Payment\PaymentSystem;


class PaymentServiceProvider extends ServiceProvider
{
	public function register(): void
	{

	}

	public function boot(): void
	{
		PaymentSystem::provider(new YooKassa());

		PaymentSystem::onCreating(function (PaymentData $paymentData) {
			return $paymentData;
		});

		PaymentSystem::onSuccess(function (Payment $paymen) {
			
		});

		PaymentSystem::onError(function (string $message, Payment $paymen) {

		});
	}
}
