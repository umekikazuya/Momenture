<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 記事とタグの多対多関係を管理するためのピボットテーブル `article_tag` を作成します。
     *
     * このマイグレーションでは、以下の構成のテーブルを作成します:
     * - `article_id`: `articles` テーブルへの外部キー。記事が削除された場合、対応するレコードも自動的に削除されます。
     * - `tag_id`: `tags` テーブルへの外部キー。タグが削除された場合、対応するレコードも自動的に削除されます。
     * - `article_id` と `tag_id` の複合主キーを設定し、一意な組み合わせを保証します。
     * - レコードの作成および更新時刻を記録するタイムスタンプを追加します。
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
     * ロールバック時に article_tag テーブルを削除します。
     *
     * マイグレーションのロールバック処理により、article_tag テーブルが存在する場合に削除を試みます。
     */
    public function down(): void
    {
        Schema::dropIfExists('article_tag');
    }
};
