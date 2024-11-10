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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
			$table->enum('tipoDocumento', ['CC', 'CE', 'NIT', 'TI', 'PB']);
			$table->bigInteger('numeroDocumento')->unique()->unsigned();
			$table->string('NombreRazonSocial', 50);
			$table->string('direccion')->nullable();
			$table->bigInteger('telefono')->unique()->unsigned();
			$table->string('email')->unique();
			$table->string('departamento', 30)->nullable();
			$table->string('municipio', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
