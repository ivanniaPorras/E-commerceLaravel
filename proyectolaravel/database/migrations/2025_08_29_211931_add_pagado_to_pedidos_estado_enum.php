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
        // SQLite no soporta ALTER TABLE para ENUM, necesitamos recrear la tabla
        Schema::table('pedidos', function (Blueprint $table) {
            // Primero eliminamos la columna estado
            $table->dropColumn('estado');
        });

        Schema::table('pedidos', function (Blueprint $table) {
            // Agregamos la columna estado con el nuevo valor 'pagado'
            $table->enum('estado', ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado', 'pagado'])->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'])->default('pendiente');
        });
    }
};
