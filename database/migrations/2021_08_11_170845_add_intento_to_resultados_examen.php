<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntentoToResultadosExamen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resultados_examen', function (Blueprint $table) {
            //
            $table->integer('intento')->nullable()->after('nota');
            $table->boolean('valido')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resultados_examen', function (Blueprint $table) {
            //
            $table->dropColumn('intento');
            $table->dropColumn('valido');
        });
    }
}
