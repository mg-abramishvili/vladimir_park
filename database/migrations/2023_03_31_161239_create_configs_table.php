<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('theme');
            $table->string('orientation');
            $table->string('title');
            $table->string('logo')->nullable();
            $table->string('key')->nullable();
            $table->boolean('activated')->default(false);
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_sec')->nullable();
            $table->string('smtp_user')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('email_from')->nullable();
            $table->string('email_to')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
