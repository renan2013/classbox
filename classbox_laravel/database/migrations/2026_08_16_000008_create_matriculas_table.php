<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('programa');
            $table->string('nacionalidad')->default('Costarricense');
            $table->string('codigo_pais', 10)->nullable();
            $table->string('email');
            $table->string('whatsapp', 50);
            $table->string('foto')->nullable();
            $table->string('documentos')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('estado', ['pendiente', 'contactado', 'matriculado', 'cancelado'])->default('pendiente');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
