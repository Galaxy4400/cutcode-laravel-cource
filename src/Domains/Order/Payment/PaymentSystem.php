<?php

namespace Domains\Order\Payment;

use Closure;
use Throwable;
use Domains\Order\Models\Payment;
use Domains\Order\Traits\PaymentEvents;
use Domains\Order\Models\PaymentHistory;
use Domains\Order\Contracts\PaymentGatewayContract;
use Domains\Order\Exceptions\PaymentProcessException;
use Domains\Order\Exceptions\PaymentProviderException;
use Domains\Order\States\Payment\PaidPaymentState;

class PaymentSystem
{
	use PaymentEvents;
	
	protected static PaymentGatewayContract $provider;


	public static function provider(PaymentGatewayContract|Closure $provider): void
	{
		if (is_callable($provider)) {
			$provider = call_user_func($provider);
		}

		if (!$provider instanceof PaymentGatewayContract) {
			throw PaymentProviderException::providerRequired();
		}
		
		self::$provider = $provider;
	}


	public static function create(PaymentData $paymentData): PaymentGatewayContract
	{
		if (!self::$provider instanceof PaymentGatewayContract) {
			throw PaymentProviderException::providerRequired();
		}

		Payment::query()->create([
			'payment_id' => $paymentData->id,
		]);

		if (is_callable(self::$onCreating)) {
			$paymentData = call_user_func(self::$onCreating, $paymentData);
		}

		return self::$provider->data($paymentData);
	}


	public static function validate(): PaymentGatewayContract
	{
		if (!self::$provider instanceof PaymentGatewayContract) {
			throw PaymentProviderException::providerRequired();
		}

		PaymentHistory::query()->create([
			'method' => request()->method(),
			'payload' => self::$provider->request(),
			'payment_gateway' => get_class(self::$provider),
		]);

		if (is_callable(self::$onValidating)) {
			call_user_func(self::$onValidating);
		}

		if (self::$provider->validate() && self::$provider->paid()) {
			try {
				$payment = Payment::query()
					->where('payment_id', self::$provider->paymentId())
					->firstOr(function () {
						throw PaymentProcessException::paymentNotFound();
					});

				if (is_callable(self::$onSuccess)) {
					call_user_func(self::$onSuccess, $payment);
				}

				$payment->state->transitionTo(PaidPaymentState::class);

			} catch (PaymentProcessException $exception) {
				if (is_callable(self::$onError)) {
					call_user_func(
						self::$onError, 
						self::$provider->errorMessage()) ?? $exception->getMessage();
				}
			}
		}

		return self::$provider;
	}
}
