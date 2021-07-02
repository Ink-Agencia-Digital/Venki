<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrofeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trofeos', function (Blueprint $table) {
            $table->id();
            $table->decimal('rangoini',8,2);
            $table->decimal('rangofin',8,2);
            $table->string('nombre',50);
            $table->string('imagen',255);
            $table->softDeletes();
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
        Schema::dropIfExists('trofeos');
    }
}
