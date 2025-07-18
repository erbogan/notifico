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
        Schema::create('table_genders', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_de')->nullable();
            $table->string('name_tr')->nullable();
            $table->string('description_en')->nullable();
            $table->string('description_de')->nullable();
            $table->string('description_tr')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_genders');
    }
};
