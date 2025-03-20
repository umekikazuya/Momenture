<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * タグテーブルを作成するマイグレーションを実行する。
     *
     * このマイグレーションでは、'tags' テーブルを作成し、以下のカラムを定義します:
     * - id: 自動増分の主キー
     * - name: 最大100文字の一意な文字列
     * - timestamps: 作成および更新のタイムスタンプ
     * - softDeletes: ソフトデリート用の日時カラム
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * マイグレーションのロールバック処理を実行し、存在する場合は `tags` テーブルを削除します。
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
