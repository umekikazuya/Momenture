<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `tags`テーブルの作成を実行するマイグレーションです。
     *
     * このメソッドは、以下のカラムを持つ`tags`テーブルを作成します:
     * - `id`: 自動増分の主キー
     * - `name`: 最大100文字のユニークな文字列カラム
     * - タイムスタンプ: 作成日時と更新日時を自動管理
     * - 論理削除: 削除時にレコードを物理削除せず論理削除するためのカラム
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
     * マイグレーションの変更を元に戻します。
     *
     * タグテーブルが存在する場合、そのテーブルを削除します。
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
