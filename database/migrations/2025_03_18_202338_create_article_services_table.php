<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * article_services テーブルを作成してマイグレーションを実行します。
     *
     * このメソッドは、以下の構造の article_services テーブルを作成します:
     * - id: 自動増分の主キー
     * - name: 最大100文字のユニークな文字列列
     * - created_at および updated_at: レコード作成日時と更新日時を記録するタイムスタンプ
     * - deleted_at: レコードのソフトデリートに使用されるタイムスタンプ
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
     * マイグレーションのロールバックを実行し、article_servicesテーブルを削除します。
     *
     * このメソッドは、マイグレーションで作成されたarticle_servicesテーブルが存在する場合にテーブルを削除し、データベーススキーマを元の状態に戻します。
     */
    public function down(): void
    {
        Schema::dropIfExists('article_services');
    }
};
