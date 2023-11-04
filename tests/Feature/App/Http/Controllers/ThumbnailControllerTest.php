<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Intervention\Image\Exception\NotReadableException;

class ThumbnailControllerTest extends TestCase
{
	use RefreshDatabase;

	protected string $disk = 'images';

	protected string $dir = 'test';

	protected string $method = 'resize';
	
	protected string $size = '345x320';
	
	protected string $file = 'test.jpg';

	protected string $resultPath;


	protected function setUp(): void
	{
		parent::setUp();

		$this->resultPath = "{$this->dir}/{$this->method}/{$this->size}/{$this->file}";
	}


	private function generateTestImage(string $dir, string $file): string
	{
		$path = UploadedFile::fake()
			->image($file)
			->storeAs($dir, $file, $this->disk);

		return $path;
	}


	private function request(): TestResponse
	{
		return $this->get(action([ThumbnailController::class], [
			'dir' => $this->dir,
			'method' => $this->method,
			'size' => $this->size,
			'file' => $this->file,
		]));
	}


	/**
	 * @return void
	 */
	public function test_thumbnail_creating_success(): void
	{
		$storage = Storage::fake($this->disk);

		$realPath = $this->generateTestImage($this->dir, $this->file);

		$this->assertTrue($storage->exists($realPath));

		$this->request()->assertHeader('content-type', 'image/jpeg');

		$this->assertTrue($storage->exists($this->resultPath));
	}


	/**
	 * @return void
	 */
	public function test_image_does_not_exist(): void
	{
		Storage::fake($this->disk);

		$this->file = 'no_existing_img.jpg';

		$response = $this->request();

		$response->assertStatus(403);
		$response->assertSeeText('The specified file does not exist');
	}


	/**
	 * @return void
	 */
	public function test_size_does_not_alowed(): void
	{
		Storage::fake($this->disk);

		$this->size = '9999x9999';

		$response = $this->request();

		$response->assertStatus(403);
		$response->assertSeeText('Size not allowed');
	}
	

}