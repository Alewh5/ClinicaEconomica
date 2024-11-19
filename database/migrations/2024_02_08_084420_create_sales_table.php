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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
			$table->foreignId('customer_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->string('codigo')->unique();
			$table->date('fechaEmision');
			$table->enum('metodoPago', ['Efectivo', 'Nequi', 'Tarjeta', 'Credito']);
			$table->boolean('estadoFactura');
			$table->decimal('subTotal', 10, 2);
			$table->decimal('impuestos', 10, 2);
			$table->decimal('total', 10, 2);
			$table->decimal('deuda', 10, 2)->nullable();
			$table->decimal('descuento_global', 10, 2);
			$table->decimal('valor_descuentoGlobal', 10, 2);
			$table->decimal('descuento_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
