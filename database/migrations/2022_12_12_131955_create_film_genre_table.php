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
        Schema::table('film_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained('film');
            $table->foreignId('genre_id')->constrained('genre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('film_genre', function (Blueprint $table) {
            //
        });
    }
};
