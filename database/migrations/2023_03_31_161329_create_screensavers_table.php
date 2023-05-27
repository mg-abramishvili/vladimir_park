<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('screensavers', function (Blueprint $table) {
            $table->id();
            $table->integer('page_id')->nullable();
            $table->string('name');
            $table->string('type');
            $table->string('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screensavers');
    }
};
