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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('descripcion');
            $table->decimal('precio', 10, 2);
            $table->decimal('iva_compra', 5, 2);
			$table->decimal('iva_venta', 5, 2);
			$table->string('marca')->nullable();
            $table->string('categoria')->nullable();
			$table->enum('estado', ['activo', 'descontinuado', 'en espera'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
