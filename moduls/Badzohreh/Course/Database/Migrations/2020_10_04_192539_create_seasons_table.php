<?php

use Badzohreh\Course\Models\Season;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonsTable extends Migration
{

    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger("course_id")->unsigned();
            $table->string("title",255);
            $table->integer("number")->nullable();
            $table->enum("confirmation_status", Season::$STATUSES)->default(Season::STATUS_PENDING);
            $table->timestamps();

            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("CASCADE");

            $table->foreign("course_id")
                ->references("id")
                ->on("courses")
                ->onDelete("CASCADE");
        });
    }
    public function down()
    {
        Schema::dropIfExists('seasons');
    }
}
