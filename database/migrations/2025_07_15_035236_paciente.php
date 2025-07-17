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
        Schema::create('pacientes', function (Blueprint $table) {
    $table->id();
    
    $table->unsignedBigInteger('tipo_documento_id');
    $table->string('numero_documento', 100);

    $table->text('nombre1')->nullable();
    $table->text('nombre2')->nullable();
    $table->text('apellido1')->nullable();
    $table->text('apellido2')->nullable();

    $table->unsignedBigInteger('genero_id');
    $table->unsignedBigInteger('departamento_id');
    $table->unsignedBigInteger('municipio_id');
    
    $table->text('correo')->nullable();
    $table->timestamps();

    $table->foreign('tipo_documento_id')->references('id')->on('tipos_documentos')->onDelete('cascade');
    $table->foreign('genero_id')->references('id')->on('genero')->onDelete('cascade');
    $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
    $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
