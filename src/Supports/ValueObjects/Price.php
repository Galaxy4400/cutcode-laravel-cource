<?php

namespace Supports\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Supports\Traits\Makeable;


/**
 * @method static static make(int $value, string $currency = 'RUB', int $precision = 100)
 */
class Price implements Stringable
{
	use Makeable;

	private array $currencies = [
		'RUB' => '₽',
	];


	public function __construct(
		private readonly int $value,
		private readonly string $currency = 'RUB',
		private readonly int $precision = 100
	)
	{
		if ($value < 0) {
			throw new InvalidArgumentException('The price cannot be less than zero');
		}
		
		if (!isset($this->currencies[$currency])) {
			throw new InvalidArgumentException('The currency is not available');
		}
	}


	public function raw(): int
	{
		return $this->value;
	}


	public function value(): int|float
	{
		return $this->value / $this->precision;
	}


	public function currency(): string
	{
		return $this->currency;
	}

	
	public function symbol(): string
	{
		return $this->currencies[$this->currency];
	}


	public function __toString(): string
	{
		return number_format($this->value(), 2, ',', ' ') . ' ' . $this->symbol();
	}

}
