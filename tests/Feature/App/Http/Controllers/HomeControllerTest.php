<?php

namespace Tests\Feature\App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class HomeControllerTest extends TestCase
{
	use RefreshDatabase;

	
	public function test_home_page_success(): void
	{
		$response = $this->get(route('home'));

		$response->assertStatus(200);
	}
}
