<?php

use Domains\Order\Models\Order;
use Domains\Product\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

	public function up(): void
	{
		Schema::create('order_items', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->integer('price')->unsigned();
			$table->integer('quantity')->unsigned();
			$table->timestamps();
		});
	}


	public function down(): void
	{
		if (app()->isLocal()) {
			Schema::dropIfExists('order_items');
		}
	}

};
