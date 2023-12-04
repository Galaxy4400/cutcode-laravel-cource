<?php

namespace Domains\Order\DTOs;

use Supports\Traits\Makeable;


/**
 * @method static static make(string $first_name, string $last_name, string $email, string $phone, string $city, string $address)
 */
class OrderCustomerDTO
{
	use Makeable;


	public function __construct(
		public readonly string $first_name,
		public readonly string $last_name,
		public readonly string $email,
		public readonly string $phone,
		public readonly string $city,
		public readonly string $address,
	) {
	}


	public function fullName(): string
	{
		return sprintf('%s %s', [$this->last_name, $this->first_name]);
	}

	
	public static function fromArray(array $array): self
	{
		return self::make(
			$array['first_name'] ?? '',
			$array['last_name'] ?? '',
			$array['email'] ?? '',
			$array['phone'] ?? '',
			$array['city'] ?? '',
			$array['address'] ?? '',
		);
	}


	public function toArray(): array
	{
		return [
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'email' => $this->email,
			'phone' => $this->phone,
			'city' => $this->city,
			'address' => $this->address,
		];
	}
}
