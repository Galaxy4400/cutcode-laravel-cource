<?php

use Domains\Product\Models\Product;
use Illuminate\Support\Facades\Schema;
use Domains\Product\Models\OptionValue;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

	public function up(): void
	{
		Schema::create('option_value_product', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(OptionValue::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->timestamps();
		});
	}


	public function down(): void
	{
		if (app()->isLocal()) {
			Schema::dropIfExists('option_value_product');
		}
	}

};
