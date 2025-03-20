<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * article_servicesテーブルを作成するマイグレーションを実行します。
     *
     * このメソッドは、article_servicesテーブルを作成し、以下のカラムを定義します:
     * - id: 自動インクリメントされる主キー
     * - name: 100文字以内のユニークな文字列カラム
     * - timestamps: 作成日時と更新日時を管理するカラム
     * - softDeletes: 論理削除用のdeleted_atカラム
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
     * マイグレーションの取り消し処理を実行する。
     *
     * このメソッドは、既存の `article_services` テーブルが存在する場合に、それをデータベースから削除し、マイグレーションをロールバックします。
     */
    public function down(): void
    {
        Schema::dropIfExists('article_services');
    }
};
