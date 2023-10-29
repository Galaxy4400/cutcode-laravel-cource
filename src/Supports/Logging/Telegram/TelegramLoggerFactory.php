<?php

namespace Supports\Logging\Telegram;

use Monolog\Logger;
use Supports\Logging\Telegram\TelegramLoggerHandler;

class TelegramLoggerFactory
{
	public function __invoke(array $config): Logger
	{
		$logger = new Logger('telegram');

		$logger->pushHandler(new TelegramLoggerHandler($config));

		return $logger;
	}
}
