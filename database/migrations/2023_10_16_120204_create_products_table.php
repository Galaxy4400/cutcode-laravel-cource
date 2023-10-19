<?php

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
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
			$table->foreignIdFor(Brand::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
			$table->timestamps();
		});

		Schema::create('category_product', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
		});
	}


	public function down(): void
	{
		if (app()->isLocal()) {
			Schema::dropIfExists('category_product');
			Schema::dropIfExists('products');
		}
	}
};
