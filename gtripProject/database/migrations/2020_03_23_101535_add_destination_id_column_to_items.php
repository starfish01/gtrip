<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDestinationIdColumnToItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gumtree_item', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('destination_details_id');
            $table->foreign('destination_details_id')->references('id')->on('destination_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gumtree_item', function (Blueprint $table) {
            //
        });
    }
}
