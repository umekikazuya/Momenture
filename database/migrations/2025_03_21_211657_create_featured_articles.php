<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * featured_articles テーブルを作成するマイグレーション処理。
     *
     * このメソッドは featured_articles テーブルを生成し、以下のカラムを定義します:
     * - id: ビッグインテジャー型の自動増分プライマリキー。
     * - article_id: articles テーブルと関連付けられた外部キー。ユニーク制約があり、参照先の記事が削除されると連鎖削除が実行されます。
     * - priority: 表示優先度を示す整数型のカラム。インデックスが付与されています。
     * - is_active: デフォルト値 true のブール型カラムで、有効フラグとして機能します。
     * - timestamps: 作成日時と更新日時を管理するカラム群。
     */
    public function up(): void
    {
        Schema::create('featured_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('article_id')->unique()->constrained('articles')->onDelete('cascade');
            $table->integer('priority')->index()->comment('表示優先度');
            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            $table->timestamps();
        });
    }

    /**
     * マイグレーションをロールバックし、featured_articles テーブルを削除します。
     *
     * テーブルが存在する場合のみ削除処理を実施し、マイグレーションの一貫性を保ちます。
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_articles');
    }
};
