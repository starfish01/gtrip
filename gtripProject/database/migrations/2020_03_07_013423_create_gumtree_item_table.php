<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGumtreeItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gumtree_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->String('title');
            $table->String('url');
            $table->String('item_id');
            $table->String('createdAt');
            $table->String('location');
            $table->String('distance');
            $table->String('suburb');
            $table->boolean('email_sent')->default(0);
            $table->boolean('filtered_out')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gumtree_item');
    }
}
