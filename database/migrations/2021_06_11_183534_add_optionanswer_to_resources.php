<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptionanswerToResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            //
            $table->string('quiz',191)->nullable()->after('document');
            $table->string('tiporespuesta',191)->nullable();
            $table->string('optionanswer',256)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropcolumn('quiz');
            $table->dropColumn('tiporespuesta');
            $table->dropColumn('optionanswer');
        });
    }
}
