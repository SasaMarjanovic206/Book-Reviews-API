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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->text('description');
            $table->double('average_rating', 2, 1);
            $table->string('book_path')->nullable();
            $table->smallInteger('page_number')->unsigned()->nullable();
            $table->string('publisher')->nullable();
            $table->string('edition')->nullable();
            $table->string('language')->nullable();
            $table->string('format')->nullable();
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
        Schema::dropIfExists('books');
    }
};
