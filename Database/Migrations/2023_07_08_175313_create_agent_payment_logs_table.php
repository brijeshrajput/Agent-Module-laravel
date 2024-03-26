<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentPaymentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_id')->unsigned();
            $table->integer('amount')->unsigned();
            $table->string('payment_details')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('txn_code')->nullable();

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
        Schema::dropIfExists('agent_payment_logs');
    }
}
