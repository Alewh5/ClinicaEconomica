<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movement_product', function (Blueprint $table) {
            $table->id();
			$table->foreignId('movement_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->integer('cantidad');
			$table->decimal('costo_unitario', 10, 2);
			$table->decimal('costo_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_product');
    }
};
