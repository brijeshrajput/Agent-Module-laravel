<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if(!Schema::hasTable('agent_clients')){
        Schema::create('agent_clients', function (Blueprint $table) {
            $table->id();

            $table->string('agent_id');
            $table->string('user_id');
            $table->string('progress')->default('0');
            $table->timestamps();
        });
        //}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_clients');
    }
}
