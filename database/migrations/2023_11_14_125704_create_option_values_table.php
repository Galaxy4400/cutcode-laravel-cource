<?php

use App\Models\Option;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

	public function up(): void
	{
		Schema::create('option_values', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Option::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->string('title');
			$table->timestamps();
		});
	}


	public function down(): void
	{
		if (app()->isLocal()) {
			Schema::dropIfExists('option_values');
		}
	}

};
