<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{

    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable();
            $table->string("transaction_id", 30)->nullable();
            $table->json("from")->nullable();
            $table->json("to")->nullable();
            $table->bigInteger("amount")->unsigned();
            $table->timestamp("setteld_at")->nullable();
            $table
                ->enum("status", \Badzohreh\Payment\Models\Settlement::$STATUSES)
                ->default(\Badzohreh\Payment\Models\Settlement::STATUS_PENDING);
            $table->timestamps();


            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("SET NULL")
                ->onUpdate("CASCADE");
        });
    }


    public function down()
    {
        Schema::dropIfExists('settlements');
    }
}
