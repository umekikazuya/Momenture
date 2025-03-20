<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * データベースマイグレーションを実行し、article_servicesテーブルを作成する。
     *
     * このテーブルは以下のカラムを含みます:
     * - id: 自動インクリメントする主キー
     * - name: 最大100文字の一意な文字列
     * - created_at, updated_at: レコードの作成時および更新時のタイムスタンプ
     * - deleted_at: ソフトデリート用のタイムスタンプ
     */
    public function up(): void
    {
        Schema::create('article_services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * マイグレーションのロールバック処理を実行する。
     *
     * このメソッドは、'article_services' テーブルが存在する場合に削除して、
     * データベースをマイグレーション適用前の状態に戻します。
     */
    public function down(): void
    {
        Schema::dropIfExists('article_services');
    }
};
