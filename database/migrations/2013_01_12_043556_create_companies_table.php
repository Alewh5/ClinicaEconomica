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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nit')->unique()->unsigned();
            $table->string('nombre');
            $table->string('direccion');
            $table->bigInteger('telefono')->unique()->unsigned();
            $table->string('email')->unique();
            $table->string('sitio_web')->nullable();
			$table->string('municipio');
			$table->string('departamento');
			$table->integer('codigo_postal');
            $table->decimal('presupuesto', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
