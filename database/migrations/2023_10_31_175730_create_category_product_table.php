<?php

use App\Models\Product;
use Domains\Catalog\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

	public function up(): void
	{
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
		}
	}

};
