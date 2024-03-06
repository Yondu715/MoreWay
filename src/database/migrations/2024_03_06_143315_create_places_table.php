<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->double('lat');
            $table->double('lon');
            $table->unsignedBigInteger('locality_id');
            $table->unsignedBigInteger('type_id');
            $table->timestamps();

            $table->unique(['lat', 'lon']);

            $table->foreign('locality_id')->references('id')->on('localities')->cascadeOnUpdate();
            $table->foreign('type_id')->references('id')->on('place_types')->cascadeOnUpdate();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
