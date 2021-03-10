<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SellsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_client')->unsigned();
            $table->decimal('total');
            $table->string('status');
         
                    $table->timestamps();
                    $table->foreign('id_client')->references('id')->on('clients');

        });  //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sells'); //
    }
}
