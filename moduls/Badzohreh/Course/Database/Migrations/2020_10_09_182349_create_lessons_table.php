<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("course_id")->unsigned();
            $table->bigInteger("user_id")->unsigned()->nullable();
            $table->bigInteger("season_id")->unsigned()->nullable();
            $table->bigInteger("media_id")->unsigned();
            $table->string("title",255);
            $table->string("slug")->nullable();
            $table->float("number")->nullable();
            $table->tinyInteger("time")->nullable();
            $table->boolean("free")->default(true);
            $table->enum("confirmation_staus",\Badzohreh\Course\Models\Lesson::$CONFIRMATION_STATUS)->default(\Badzohreh\Course\Models\Lesson::CONFIRMATION_STATUS_PENDING);
            $table->enum("status",\Badzohreh\Course\Models\Lesson::$STATUSES)->default(\Badzohreh\Course\Models\Lesson::STATUS_OPENED);
            $table->timestamps();

            $table->foreign("course_id")
                ->references("id")
                ->on("courses")
                ->onDelete("CASCADE");

            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("SET NULL");

            $table->foreign("season_id")
                ->references("id")
                ->on("seasons")
                ->onDelete("SET NULL");


            $table->foreign("media_id")
                ->references("id")
                ->on("media")
                ->onDelete("CASCADE");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
