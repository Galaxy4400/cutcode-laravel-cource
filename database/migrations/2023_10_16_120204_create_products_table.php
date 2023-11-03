<?php

use Domains\Catalog\Models\Brand;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

	public function up(): void
	{
		Schema::create('products', function (Blueprint $table) {
			$table->id();
			$table->string('slug')->unique();
			$table->string('title');
			$table->string('thumbnail')->nullable();
			$table->integer('price')->unsigned()->default(0);
			$table->boolean('on_home_page')->default(false);
			$table->integer('sorting')->default(0);
			$table->foreignIdFor(Brand::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
			$table->timestamps();
		});
	}


	public function down(): void
	{
		if (app()->isLocal()) {
			Schema::dropIfExists('products');
		}
	}
};
