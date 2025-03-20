<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * この記事とタグのリレーションを表す中間テーブル `article_tag` を作成します。
     *
     * このマイグレーションでは、以下の処理を実行します:
     * - `article_tag` テーブルを作成
     * - `articles` テーブルへの外部キー `article_id` と `tags` テーブルへの外部キー `tag_id` を追加し、
     *   削除時に連動して該当レコードを削除するように設定
     * - `article_id` と `tag_id` の複合主キーを定義
     * - レコードの作成・更新時刻を管理するタイムスタンプを追加
     */
    public function up(): void
    {
        Schema::create('article_tag', function (Blueprint $table) {
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->primary(['article_id', 'tag_id']);
            $table->timestamps();
        });
    }

    /**
     * ロールバック処理: article_tag テーブルが存在する場合に削除します。
     */
    public function down(): void
    {
        Schema::dropIfExists('article_tag');
    }
};
