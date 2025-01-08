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
        Schema::create('oquv_uslubiy_ish', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('uslubiy_nashr_turi');
            $table->string('uslubiy_nashr_tili');
            $table->string('uslubiy_nashr_nomi');
            $table->string('mualliflar_soni');
            $table->string('mualliflar');
            $table->string('nashriyot')->nullable();
            $table->string('nashr_parametrlari');
            $table->string('nashr_yili');
            $table->string('guvohnoma_raqami')->nullable();
            $table->date('guvohnoma_sanasi')->nullable();
            $table->string('oquv_yili');
            $table->string('file_path')->nullable();
            $table->timestamps();


            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oquv_uslubiy_ish');
    }
};
