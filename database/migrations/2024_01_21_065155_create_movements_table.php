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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
			$table->foreignId('cellar_id');
            $table->foreign('cellar_id')->references('id')->on('cellars')->onDelete('cascade')->onUpdate('cascade');
            $table->date('fecha');
            $table->boolean('tipoMovimiento');
            $table->string('concepto');
			$table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
