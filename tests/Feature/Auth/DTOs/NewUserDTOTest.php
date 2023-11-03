<?php

namespace Tests\Feature\Auth\DTOs;

use App\Http\Requests\SignUpFormRequest;
use Domains\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
	use RefreshDatabase;

	
	public function test_instance_created_form_form_request(): void
	{
		$dto = NewUserDTO::fromRequest(new SignUpFormRequest([
			'name' => 'test',
			'email' => 'test@email.ru',
			'password' => '12345678',
		]));

		$this->assertInstanceOf(NewUserDTO::class, $dto);
	}
}
