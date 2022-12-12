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
        Schema::table('film_director', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained('film');
            $table->foreignId('person_id')->constrained('person');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('film_director', function (Blueprint $table) {
            //
        });
    }
};
