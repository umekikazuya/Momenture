<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 記事テーブルを作成するマイグレーションを実行します。
     *
     * このメソッドは、'articles' テーブルを以下のカラムで作成します:
     *   - id: 自動インクリメントによるプライマリーキー
     *   - title: 最大255文字の文字列
     *   - status: 'draft'または'published'の値を持つ列
     *   - article_service_id: 'article_services' テーブルのidを参照する外部キー（削除時にカスケード）
     *   - link: 最大255文字の文字列（NULL許容）
     *   - timestamps: 作成日時および更新日時
     *   - softDeletes: ソフトデリート用のdeleted_at列
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
     * マイグレーションの反転処理を実行する。
     *
     * このメソッドは、articles テーブルが存在する場合に削除します。
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
