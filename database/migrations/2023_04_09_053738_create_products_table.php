<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->integer('category_id')->default(0);
            $table->string('description')->nullable();
            $table->integer('price')->default(0);
            $table->text('content')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('total_vote')->default(0);
            $table->integer('stat_vote')->default(0);
            $table->integer('age_vote')->default(0);
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
        Schema::dropIfExists('products');
    }
}
