<?php

use Domains\Auth\Models\User;
use Domains\Order\Enums\OrderStatuses;
use Domains\Order\Models\DeliveryType;
use Illuminate\Support\Facades\Schema;
use Domains\Order\Models\PaymentMethod;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

	public function up(): void
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(DeliveryType::class)->constrained();
			$table->foreignIdFor(PaymentMethod::class)->constrained();
			$table->integer('total')->unsigned()->default(0);
			$table->enum('status', array_column(OrderStatuses::cases(), 'value'))->default('new');
			$table->timestamps();
		});
	}


	public function down(): void
	{
		if (app()->isLocal()) {
			Schema::dropIfExists('orders');
		}
	}

};
