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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->integer('budget');
            $table->string('homepage');
            $table->foreignId('original_language_id')->constrained('language');
            $table->longText('overview');
            $table->decimal('popularity', 10, 3);
            $table->string('poster_path');
            $table->date('release_date');
            $table->integer('revenue');
            $table->integer('runtime');
            $table->string('tagline');
            $table->string('title');
            $table->decimal('vote_average', 3, 1);
            $table->integer('vote_count');
            $table->json('external_ids');
            $table->json('similar');
            $table->foreignId('certification_id')->constrained('certification');
            $table->string('trailer_yt');
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
        Schema::dropIfExists('films');
    }
};
