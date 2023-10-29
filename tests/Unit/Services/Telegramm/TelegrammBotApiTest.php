<?php

namespace Tests\Unit\Services\Telegramm;

use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Tests\TestCase;

class TelegrammBotApiTest extends TestCase
{
	public function test_send_message_success(): void
	{
		Http::fake([
			TelegramBotApi::HOST . '*' => Http::response(['ok' => true]),
		]);

		$result = TelegramBotApi::sendMessage('', 1, 'test');

		$this->assertTrue($result);
	}
}
