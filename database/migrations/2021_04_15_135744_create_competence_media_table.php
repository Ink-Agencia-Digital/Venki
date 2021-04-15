<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetenceMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competence_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competence_id');
            $table->string('media');
            $table->timestamps();
            $table->foreign('competence_id')
                ->references('id')
                ->on('competences')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competence_media');
    }
}
