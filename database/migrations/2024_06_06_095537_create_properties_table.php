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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('en_name');
            $table->string('ar_name');
            $table->longText('en_description');
            $table->longText('ar_description');
            $table->string('total_price');
            $table->integer('number');
            $table->string('area');
            $table->string('address');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')
            ->references('id')
            ->on('p_sections')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->boolean('is_best')->default(0);
            $table->string('longitude');
            $table->string('latitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
