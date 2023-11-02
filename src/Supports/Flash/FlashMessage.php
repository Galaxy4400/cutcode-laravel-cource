<?php

namespace Supports\Flash;

class FlashMessage
{

	public function __construct(
		protected string $message, 
		protected string $class
	)
	{
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
