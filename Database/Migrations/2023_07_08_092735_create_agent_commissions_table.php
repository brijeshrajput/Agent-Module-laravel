<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // refiee is the another agent referred by the agent
        Schema::create('agent_commissions', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_id')->nullable();
            $table->integer('payment_log_id')->nullable();
            $table->integer('ag_ref_id')->nullable();
            $table->string('type')->nullable();
            $table->double('amount', 20, 2)->nullable();

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
        Schema::dropIfExists('agent_commissions');
    }
}
