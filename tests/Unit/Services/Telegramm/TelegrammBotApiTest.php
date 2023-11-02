<?php

namespace Tests\Unit\Services\Telegramm;

use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;
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


	public function test_send_message_success_by_fake_instence(): void
	{
		TelegramBotApi::fake()->returnTrue();

		$result = app(TelegramBotApiContract::class)::sendMessage('', 1, 'Testing');

		$this->assertTrue($result);
	}


	public function test_send_message_fail_by_fake_instence(): void
	{
		TelegramBotApi::fake()->returnFalse();

		$result = app(TelegramBotApiContract::class)::sendMessage('', 1, 'Testing');

		$this->assertFalse($result);
	}

}
