<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hodoor_enserafs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->time('come')->nullable();
            $table->time('go')->nullable();
            $table->string('time' ,10)->nullable();
            $table->date('date')->nullable();
            $table->double('difference')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('user');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hodoor_enserafs');
    }
};
