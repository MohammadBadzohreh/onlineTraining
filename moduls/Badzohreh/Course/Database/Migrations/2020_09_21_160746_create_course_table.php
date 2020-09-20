<?php

use Badzohreh\Course\Models\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("teacher_id")->unsigned();
            $table->bigInteger("category_id")->unsigned()->nullable();
            $table->bigInteger("banner_id")->unsigned();

            $table->string("title");
            $table->string("slug");
            $table->float("priority")->nullable();
            $table->string("price", 10);
            $table->float("percent");
            $table->enum("type", Course::$TYPES);
            $table->enum("status", Course::$STATUSES);
            $table->text("body")->nullable();
            $table->timestamps();

            $table->foreign("teacher_id")
                ->references("id")
                ->on("users")
                ->onDelete("CASCADE");

            $table->foreign("category_id")
                ->references("id")
                ->on("categories")
                ->onDelete("SET NULL");

            $table->foreign("banner_id")
                ->references("id")
                ->on("media")
                ->onDelete("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
