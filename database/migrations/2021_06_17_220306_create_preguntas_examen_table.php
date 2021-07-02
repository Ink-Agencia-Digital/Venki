<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasExamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas_examen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_examen');
            $table->string('pregunta',255);
            $table->string('tiporespuesta',50);
            $table->string('opciones',255)->nullable();
            $table->decimal('valor',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preguntas_examen');
    }
}
