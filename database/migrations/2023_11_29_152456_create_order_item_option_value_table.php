<?php

use Domains\Order\Models\OrderItem;
use Illuminate\Support\Facades\Schema;
use Domains\Product\Models\OptionValue;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

	public function up(): void
	{
		Schema::create('order_item_option_value', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(OrderItem::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(OptionValue::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->timestamps();
		});
	}


	public function down(): void
	{
		if (app()->isLocal()) {
			Schema::dropIfExists('order_item_option_value');
		}
	}

};
