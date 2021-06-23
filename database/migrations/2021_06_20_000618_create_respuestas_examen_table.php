<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasExamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas_examen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_examen');
            $table->string('pregunta',255);
            $table->string('respuesta',255)->nullable();
            $table->decimal('valor',8,2);
            $table->boolean('correcto')->default(false);
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_examen')->references('id')->on('examenes');
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
        Schema::dropIfExists('respuestas_examen');
    }
}
