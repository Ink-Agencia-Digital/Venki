<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('placeOfBirth',191)->nullable()->after('confirmation_code');
            $table->string('height',191)->nullable();
            $table->string('weight',191)->nullable();
            $table->string('dominantFoot',191)->nullable();
            $table->string('dominantHand',191)->nullable();
            $table->string('graduationYear',191)->nullable();
            $table->string('highSchoolAverage',191)->nullable();
            $table->string('gpa',191)->nullable();
            $table->string('sat',191)->nullable();
            $table->string('toef',191)->nullable();
            $table->string('mainSport',191)->nullable();
            $table->string('playingPosition',191)->nullable();
            $table->string('events',191)->nullable();
            $table->string('time',191)->nullable();
            $table->string('records',191)->nullable();
            $table->string('route',191)->nullable();
            $table->string('rankings',191)->nullable();
            $table->string('recognitions',191)->nullable();
            $table->string('press',191)->nullable();
            $table->string('differences',191)->nullable();
            $table->string('competencies',191)->nullable();
            $table->string('goals',191)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropcolumn('placeOfBirth');
            $table->dropcolumn('height');
            $table->dropcolumn('weight');
            $table->dropcolumn('dominantFoot');
            $table->dropcolumn('dominantHand');
            $table->dropcolumn('graduationYear');
            $table->dropcolumn('highSchoolAverage');
            $table->dropcolumn('gpa');
            $table->dropcolumn('sat');
            $table->dropcolumn('toef');
            $table->dropcolumn('mainSport');
            $table->dropcolumn('playingPosition');
            $table->dropcolumn('events');
            $table->dropcolumn('time');
            $table->dropcolumn('records');
            $table->dropcolumn('route');
            $table->dropcolumn('rankings');
            $table->dropcolumn('recognitions');
            $table->dropcolumn('press');
            $table->dropcolumn('differences');
            $table->dropcolumn('competencies');
            $table->dropcolumn('goals');
        });
    }
}
