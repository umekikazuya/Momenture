<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ピボットテーブル `article_tag` を生成し、記事とタグ間の多対多の関連付けを定義するマイグレーションを実行します。
     *
     * このメソッドは、以下の処理を行います:
     * - `article_id` と `tag_id` の外部キーを持つ `article_tag` テーブルを作成し、それぞれ `articles` および `tags` テーブルと連携。
     * - 両外部キーに対して削除時に連鎖削除が適用されるよう設定。
     * - `article_id` と `tag_id` の複合主キーを定義。
     * - レコードの作成時刻および更新時刻を記録するタイムスタンプを追加。
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
     * マイグレーションのロールバック時に、`article_tag` テーブルが存在すれば削除する。
     *
     * このメソッドは、記事とタグ間の多対多リレーションを定義するために作成したピボットテーブルの削除を行い、
     * マイグレーションのロールバック処理を完了します。
     */
    public function down(): void
    {
        Schema::dropIfExists('article_tag');
    }
};
