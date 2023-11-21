<?php

use Domains\Cart\Models\Cart;
use Domains\Product\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

	public function up(): void
	{
		Schema::create('cart_items', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Cart::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->unsignedBigInteger('price');
			$table->integer('quantity');
			$table->string('options')->nullable();
			$table->timestamps();
		});
	}


	public function down(): void
	{
		if (app()->isLocal()) {
			Schema::dropIfExists('cart_items');
		}
	}

};
