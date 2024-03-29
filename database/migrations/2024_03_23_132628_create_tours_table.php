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
        Schema::create('tours', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('travel_id')->constrained('travels');

            $table->string('name');
            $table->date('starting_date')->nullable(false);
            $table->date('ending_date')->nullable(false);
            $table->unsignedInteger('price')->nullable(false);

            $table->timestamps();

            $table->index('starting_date');
            $table->index('ending_date');
            $table->index('price');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
