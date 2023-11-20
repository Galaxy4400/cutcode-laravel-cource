<?php

use Domains\Cart\Models\CartItem;
use Domains\Product\Models\OptionValue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

	public function up(): void
	{
		Schema::create('cart_item_option_value', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(CartItem::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(OptionValue::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->timestamps();
		});
	}


	public function down(): void
	{
		if (app()->isLocal()) {
			Schema::dropIfExists('cart_item_option_value');
		}
	}

};
