<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションを実行し、存在する場合は 'articles' テーブルを削除します。
     *
     * このメソッドは、データベースから 'articles' テーブルを削除することでスキーマを更新します。
     */
    public function up(): void
    {
        Schema::dropIfExists('articles');
    }

    /**
     * マイグレーションの変更を元に戻し、articles テーブルを削除します。
     *
     * このメソッドは、articles テーブルが存在する場合にのみ削除を実行することで、マイグレーションで加えた変更を取り消します。
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
