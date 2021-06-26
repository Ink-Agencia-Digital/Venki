<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultadosExamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados_examen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_examen');
            $table->unsignedBigInteger('id_trofeo');
            $table->decimal('nota',8,2);
            $table->foreign('id_user')->references('id')->on('Users');
            $table->foreign('id_examen')->references('id')->on('examenes');
            $table->foreign('id_trofeo')->references('id')->on('trofeos');
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
        Schema::dropIfExists('resultados_examen');
    }
}
