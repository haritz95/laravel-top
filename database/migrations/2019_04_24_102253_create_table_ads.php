<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_spot')->unsigned();
            $table->foreign('id_spot')->references('id')->on('table_ad_spots');
            $table->integer('id_period')->unsigned();
            $table->foreign('id_period')->references('id')->on('table_ads_period');
            $table->string('tittle');
            $table->string('website');
            $table->string('banner');
            $table->boolean('active');
            $table->integer('views')->default(0);
            $table->integer('cliks')->default(0);
            $table->dateTime('end_ad')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('table_ads');
    }
}
