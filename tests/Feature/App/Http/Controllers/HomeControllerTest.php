<?php

namespace Tests\Feature\App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
	use RefreshDatabase;

	/**
	 * A basic feature test example.
	 */
	public function test_home_page_success(): void
	{
		$response = $this->get(route('home'));

		$response->assertStatus(200);
	}
}
