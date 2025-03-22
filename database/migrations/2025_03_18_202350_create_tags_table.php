<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * タグテーブルを作成するマイグレーション処理を実行します。
     *
     * このメソッドは、'tags' テーブルを以下のカラム構成で生成します:
     * - 自動インクリメントの主キー (id)
     * - 一意制約付きの文字列型 (最大100文字) の name カラム
     * - 作成日時と更新日時のタイムスタンプ
     * - 論理削除用の softDeletes カラム
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
     * このメソッドは、`tags`テーブルが存在する場合に削除し、作成したテーブルの変更を逆転します。
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
