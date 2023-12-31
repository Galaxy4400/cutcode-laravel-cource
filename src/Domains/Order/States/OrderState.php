<?php

namespace Domains\Order\States;

use InvalidArgumentException;
use Domains\Order\Models\Order;
use Domains\Order\Events\OrderStatusChanged;


abstract class OrderState
{
	protected array $allowedTransitions = [];

	public function __construct(
		protected Order $order,
	) {
	}

	abstract public function canBeChanged(): bool;

	abstract public function value(): string;

	abstract public function humanValue(): string;


	public function transitionTo(OrderState $state): void
	{
		if (!$this->canBeChanged()) {
			throw new InvalidArgumentException("Status can't be changed");
		}
		
		if (!in_array(get_class($state), $this->allowedTransitions)) {
			throw new InvalidArgumentException("No transition for {$this->order->status->value()} to {$state->value()}");
		}

		$this->order->updateQuietly([
			'status' => $state->value(),
		]);

		event(new OrderStatusChanged(
			$this->order,
			$this->order->status,
			$state,
		));
		
	}
	
}
