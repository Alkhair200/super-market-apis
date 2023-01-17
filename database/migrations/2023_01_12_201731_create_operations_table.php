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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->string('buy_id');
            $table->unsignedBigInteger('item_id');
            $table->decimal('buy_quantity',8,2);
            $table->decimal('buy_total_g',8,2)->nullable();
            $table->decimal('buy_discound',8,2)->nullable();
            $table->decimal('buy_unit_price',8,2)->nullable();
            $table->decimal('buy_total_d',8,2)->nullable();
            $table->decimal('buy_earn',8,2)->nullable();
            $table->longText('buy_notes')->nullable();
            $table->date('buy_expire_date');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
};
