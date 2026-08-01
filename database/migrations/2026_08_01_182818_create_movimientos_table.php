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
    Schema::create('movimientos', function (Blueprint $table) {

        $table->id();

        $table->date('fecha');

        $table->string('tipo');

        $table->string('cuenta');

        $table->string('categoria')->nullable();

        $table->string('descripcion')->nullable();

        $table->decimal('importe', 14, 2);

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
