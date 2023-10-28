<?php

namespace App\Support\Flash;

class FlashMessage
{
	protected $message;

	protected $class;


	public function __construct(string $message, string $class)
	{
		$this->message = $message;
		$this->class = $class;
	}

	
	public function message()
	{
		return $this->message;
	}


	public function class()
	{
		return $this->class;
	}
}
