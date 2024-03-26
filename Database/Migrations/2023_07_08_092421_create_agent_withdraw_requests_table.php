<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentWithdrawRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_id')->nullable();
            $table->double('amount', 20, 2)->nullable();
            $table->string('message')->nullable();
            $table->integer('status')->nullable();
            $table->integer('viewed')->nullable();

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
        Schema::dropIfExists('agent_withdraw_requests');
    }
}
