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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
			$table->date('fecha_traslado');
			$table->text('detalles')->nullable();
			$table->foreignId('cellar_origen_id')->constrained('cellars')->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId('cellar_destino_id')->constrained('cellars')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
