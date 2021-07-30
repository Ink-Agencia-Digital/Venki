<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('membresia_id');
            $table->string('x_cust_id_cliente',255)->nullable();
            $table->string('x_id_factura',255)->nullable();
            $table->string('x_ref_payco',255)->nullable();
            $table->decimal('x_amount_base',18,2)->nullable();
            $table->decimal('x_tax',18,2)->nullable();
            $table->string('x_response',255)->nullable();
            $table->string('x_approval_code',255)->nullable();
            $table->string('x_transaction_id',255)->nullable();
            $table->string('x_transaction_date',255)->nullable();
            $table->string('x_cod_response',255)->nullable();
            $table->string('x_response_reason_text',255)->nullable();
            $table->string('x_error_code',255)->nullable();
            $table->string('x_transaction_state',255)->nullable();
            $table->string('x_customer_ip',255)->nullable();
            $table->string('x_franchise',255)->nullable();
            $table->string('x_signature',255)->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('membresia_id')->references('id')->on('membresias');
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
        Schema::dropIfExists('pagos');
    }
}
