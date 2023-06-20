<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->default(0);
            $table->integer('product_id')->default(0);
            $table->tinyInteger('status')->default(0)->comment('trạng thái đơn hàng');
            $table->integer('user_id')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('price')->default(0);
            $table->string('name')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('total_price')->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
