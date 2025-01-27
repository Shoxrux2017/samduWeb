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
        Schema::create('kafedra_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('kafedra_id');
            $table->unsignedBigInteger('user_id');
            
            $table->foreign('kafedra_id')->references('id')->on('kafedra');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('kafedra_teacher');
    }
};
