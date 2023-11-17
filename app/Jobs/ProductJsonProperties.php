<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


/**
 * @method static stacic dispatch($product)
 */
class ProductJsonProperties implements ShouldQueue, ShouldBeUnique
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 */
	public function __construct(
		protected Product $product,
	) {
	}

	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		$properties = $this->product->properties
			->mapWithKeys(fn ($property) => [$property->title => $property->pivot->value]);

		$this->product->updateQuietly(['json_properties' => $properties]);
	}

	/**
	 * Get the unique ID for the job.
	 */
	public function uniqueId(): string
	{
		return $this->product->getKey();
	}
}
