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
            $table->string('ISBN');
            $table->integer('publication_year');
            $table->decimal('price', 8, 2);
            $table->string('genre');
            $table->string('subgenre');
            $table->unsignedBigInteger('writer_id');
            $table->unsignedBigInteger('publisher_id');

            $table->timestamps();

            $table->foreign('writer_id')->references('id')->on('writers')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');
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
