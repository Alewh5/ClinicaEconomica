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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
			$table->enum('tipoDocumento', ['CC', 'NIT', 'TI', 'PP']);
			$table->bigInteger('numeroDocumento')->unique()->unsigned();
			$table->string('NombreRazonSocial');
			$table->string('direccion')->nullable();
			$table->bigInteger('telefono')->unique()->unsigned();
			$table->string('email')->unique();
			$table->string('departamento')->nullable();
			$table->string('municipio')->nullable();
			$table->boolean('responsable_iva')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
