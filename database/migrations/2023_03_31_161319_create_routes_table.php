<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->integer('kiosk_id');
            $table->string('name');
            $table->integer('scheme1_id');
            $table->integer('scheme2_id')->nullable();
            $table->string('floor1_text_begin')->nullable();
            $table->string('floor1_text_end')->nullable();
            $table->string('floor2_text_begin')->nullable();
            $table->string('floor2_text_end')->nullable();
            $table->text('route_code_floor1');
            $table->text('route_code_floor2')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
