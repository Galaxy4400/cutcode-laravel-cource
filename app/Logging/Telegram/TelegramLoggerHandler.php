<?php

namespace App\Logging\Telegram;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
	public function __construct($config)
	{
		$level = Logger::toMonologLevel($config['level']);

		parent::__construct($level);
	}

	protected function write(LogRecord $record): void
	{
		// $record->formatted
	}
}
