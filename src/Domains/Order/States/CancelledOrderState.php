<?php

namespace Domains\Order\States;

class CancelledOrderState extends OrderState
{
	protected array $allowedTransitions = [];


	public function canBeChanged(): bool
	{
		return false;
	}


	public function value(): string
	{
		return 'cancelle';
	}


	public function humanValue(): string
	{
		return 'Отменен';
	}
}
