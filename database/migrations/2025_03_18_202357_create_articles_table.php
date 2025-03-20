<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 'articles' テーブルを作成するマイグレーションを実行します。
     *
     * このメソッドでは、以下のカラムを持つ 'articles' テーブルを定義します:
     * - id: 自動インクリメントの主キー。
     * - title: 最大255文字の文字列。
     * - status: 'draft' または 'published' のいずれかの値を持つ列。
     * - article_service_id: 'article_services' テーブルの id を参照する外部キー（削除時に連鎖削除）。
     * - link: 最大255文字のNULL許容の文字列。
     * - timestamps: 作成日時と更新日時を自動管理。
     * - softDeletes: 論理削除用の deleted_at カラム。
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->enum('status', ['draft', 'published']);
            $table->foreignId('article_service_id')->constrained('article_services')->cascadeOnDelete();
            $table->string('link', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * マイグレーションのロールバックを実行し、'articles' テーブルを削除します。
     *
     * このメソッドは、データベース内に存在する 'articles' テーブルを削除することで、
     * マイグレーション操作を元に戻します。
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
