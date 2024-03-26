<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('agent_wallets')){
        Schema::create('agent_wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_id')->nullable();
            $table->double('balance', 20, 2)->default(0)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_details')->nullable();

            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_wallets');
    }
}
