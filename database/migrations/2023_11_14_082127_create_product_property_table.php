<?php

use Domains\Product\Models\Product;
use Domains\Product\Models\Property;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

	public function up(): void
	{
		Schema::create('product_property', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(Property::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->string('value');
			$table->timestamps();
		});
	}


	public function down(): void
	{
		if (app()->isLocal()) {
			Schema::dropIfExists('product_property');
		}
	}

};
