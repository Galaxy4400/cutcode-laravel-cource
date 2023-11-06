<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThumbnailControllerTest extends TestCase
{
	use RefreshDatabase;


	public function test_generated_success()
	{
		$size = '500x500';
		$method = 'resize';
		$storage = Storage::disk('images');

		config()->set('thumbnail', ['allowed_sizes' => [$size]]);

		$product = ProductFactory::new()->create();

		$response = $this->get($product->makeThumbnail($size, $method));

		$response->assertOk();

		$storage->assertExists("products/{$method}/{$size}/" . File::basename($product->thumbnail));
	}
}
