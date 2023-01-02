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
        Schema::create('film', function (Blueprint $table) {
            $table->id();
            $table->integer('budget')->nullable();
            $table->string('homepage')->nullable();
            $table->foreignId('original_language_id')->constrained('language');
            $table->longText('overview')->nullable();
            $table->decimal('popularity', 10, 3)->nullable();
            $table->string('poster_path')->nullable();
            $table->date('release_date')->nullable();
            $table->bigInteger('revenue')->nullable();
            $table->integer('runtime')->nullable();
            $table->string('tagline')->nullable();
            $table->string('title');
            $table->decimal('vote_average', 3, 1)->nullable();
            $table->integer('vote_count')->nullable();
            $table->json('external_ids')->nullable();
            $table->json('similar')->nullable();
            $table->foreignId('certification_id')->constrained('certification');
            $table->string('trailer_yt')->nullable();
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
        Schema::dropIfExists('film');
    }
};
