<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `articles` テーブルを作成するマイグレーション処理を実行する。
     *
     * このメソッドは `articles` テーブルを作成し、以下のカラムを定義します:
     * - id: 自動増分の主キー
     * - title: 最大255文字の文字列
     * - status: 'draft' または 'published' の値を持つenum
     * - article_service_id: `article_services` テーブルのIDを参照する外部キー（削除時に連鎖削除）
     * - link: 最大255文字の任意の文字列（NULL許容）
     * - timestamps: 作成日時と更新日時
     * - softDeletes: 論理削除のためのdeleted_atカラム
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
     * マイグレーションをロールバックし、'articles' テーブルを削除します。
     *
     * このメソッドは、既存の 'articles' テーブルが存在する場合に削除し、マイグレーションによる変更を元の状態に戻します。
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
