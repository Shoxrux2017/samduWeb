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
        Schema::create('ilmiy_ish', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->index();

            $table->string('science_category_title');
            $table->string('publish_type_title');
            $table->string('publish_level_title');
            $table->string('publish_language_title');
            $table->string('study_year_title');

            $table->string('title');
            $table->string('publish');
            $table->integer('year');
            $table->integer('page');
            $table->string('author');
            $table->string('coAuthor')->nullable();
            $table->integer('authorCount');
            $table->string('doi')->nullable();
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
        Schema::dropIfExists('ilmiy_ish');
    }
};
