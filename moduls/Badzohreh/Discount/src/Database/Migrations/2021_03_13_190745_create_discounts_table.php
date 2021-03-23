<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id")->unsigned();
            $table->string("code")->nullable();
            $table->tinyInteger("percent");
            $table->bigInteger("usage_limitation")->nullable();
            $table->timestamp("expire_at");
            $table->string("link", 300)->nullable();
            $table->text("description")->nullable();
            $table->enum("type", \Badzohreh\Discount\Models\Discount::$TYPES)->default(\Badzohreh\Discount\Models\Discount::DISCOUNT_ALL_TYPE);
            $table->tinyInteger("uses")->default(0)->unsigned();
            $table->timestamps();
        });

        Schema::create("discountables", function (Blueprint $table) {
            $table->foreignId("discount_id");
            $table->foreignId("discountable_id");
            $table->string("discountable_type");
            $table->primary(["discount_id", "discountable_id", "discountable_type"], "discount_key");
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('discountables');
    }
}
