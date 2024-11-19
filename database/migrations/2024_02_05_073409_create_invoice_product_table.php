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
        Schema::create('invoice_product', function (Blueprint $table) {
            $table->id();
			$table->foreignId('invoice_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->integer('cantidad')->unsigned();
			$table->decimal('precio_unitario', 10, 2);
			$table->decimal('descuento', 5, 2);
			$table->decimal('valor_descuento', 10, 2);
			$table->decimal('subtotal', 10, 2);
			$table->decimal('impuestos', 10, 2);
			$table->decimal('precio_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_product');
    }
};
