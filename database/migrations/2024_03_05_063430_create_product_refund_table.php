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
        Schema::create('product_refund', function (Blueprint $table) {
            $table->id();
			$table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId('refund_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->integer('cantidad');
			$table->decimal('precio_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_refund');
    }
};
