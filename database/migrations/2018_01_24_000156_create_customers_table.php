<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('fname');
            $table->string('lname');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('addr_st')->nullable();
            $table->string('addr_city')->nullable();
            $table->string('addr_prov')->nullable();
            $table->string('addr_postal')->nullable();
            $table->string('addr_country')->nullable();
            $table->text('note')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
