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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('github')->nullable();
            $table->string('qiita')->nullable();
            $table->string('address')->nullable();
            $table->string('zenn')->nullable();
            $table->jsonb('skill')->nullable();
            $table->string('display_name')->nullable();
            $table->string('display_short_name')->nullable();
            $table->string('from')->nullable();
            $table->jsonb('likes')->nullable();
            $table->text('summary_introduction')->nullable();
            $table->text('introduction')->nullable();
            $table->string('job')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
