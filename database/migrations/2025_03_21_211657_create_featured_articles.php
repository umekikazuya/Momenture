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
        Schema::create('featured_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('article_id')->unique()->constrained('articles')->onDelete('cascade');
            $table->integer('priority')->index()->comment('表示優先度');
            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_articles');
    }
};
