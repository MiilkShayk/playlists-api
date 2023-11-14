<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('musicas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('categories_id'); 
            $table->unsignedBigInteger('authors_id'); 
            $table->foreign('categories_id')->references('id')->on('musica_categories'); 
            $table->foreign('authors_id')->references('id')->on('authors'); 
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musicas');
    }
};
