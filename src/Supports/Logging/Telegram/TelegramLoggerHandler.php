<?php

namespace Supports\Logging\Telegram;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Services\Telegram\TelegramBotApiContract;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
	protected int $chatId;

	protected string $token;
	

	public function __construct($config)
	{
		$level = Logger::toMonologLevel($config['level']);
		
		parent::__construct($level);

		$this->chatId = (int)$config['chat_id'];
		$this->token = $config['token'];
	}


	protected function write(LogRecord $record): void
	{
		app(TelegramBotApiContract::class)::sendMessage(
			$this->token,
			$this->chatId,
			$record->formatted
		);
	}
}
