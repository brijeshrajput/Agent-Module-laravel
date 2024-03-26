<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('agents')){
            Schema::create('agents', function (Blueprint $table) {
                $table->id();

                $table->string('name');
                $table->unsignedTinyInteger('email_verified',false)->default(0);
                $table->string('email_verify_token')->nullable();
                $table->string('mobile',20)->nullable();
                $table->string('email')->unique();
                $table->unsignedBigInteger('image')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->string('referral_code')->nullable();
                $table->string('sponsor_id')->nullable();
                $table->tinyInteger('is_active')->default(0);
                $table->tinyInteger('verification_status')->default(0);
                $table->longText('verification_info')->nullable();

                $table->string('cash_payment_status')->nullable();
                $table->string('bank_payment_status')->nullable();
                $table->string('bank_name')->nullable();
                $table->string('bank_acc_name')->nullable();
                $table->string('bank_acc_no')->nullable();
                $table->string('bank_branch')->nullable();
                $table->string('bank_routing_no')->nullable();

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
        Schema::dropIfExists('agents');
    }
}
