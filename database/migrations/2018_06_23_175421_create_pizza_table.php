<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePizzaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pizza', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', '100');
            $table->string('dough', '50');
            $table->integer('toppings_count');
            $table->string('size', '50');
            $table->decimal('price', 4, 2);
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
        Schema::dropIfExists('pizza');
    }
}
