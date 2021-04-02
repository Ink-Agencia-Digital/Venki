<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityToAchievements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->integer('priority')->after('user_id');
            $table->date('date')->nullable()->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn('priority');
            $table->dropColumn('date');
        });
    }
}
