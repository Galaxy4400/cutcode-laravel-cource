<?php

namespace Supports\Flash;

use Supports\Flash\FlashMessage;
use Illuminate\Contracts\Session\Session;

class Flash
{
	public const MESSAGE_KEY = 'flash_message';
	public const MESSAGE_CLASS = 'flash_class';


	protected $session;
	

	public function __construct(Session $session)
	{
		$this->session = $session;
	}


	public function get(): ?FlashMessage
	{
		$message = $this->session->get(self::MESSAGE_KEY);

		if (!$message) return null;

		return new FlashMessage($message, $this->session->get(self::MESSAGE_CLASS));
	}


	public function info(string $message): void
	{
		$this->flash($message, 'info');
	}
	
	
	public function alert(string $message): void
	{
		$this->flash($message, 'alert');
	}


	private function flash(string $message, string $name): void
	{
		$this->session->flash(self::MESSAGE_KEY, $message);
		$this->session->flash(self::MESSAGE_CLASS, config("flash.{$name}"));
	}
}
