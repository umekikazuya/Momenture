<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 「articles」テーブルが存在する場合に削除するマイグレーション処理を実行します。
     */
    public function up(): void
    {
        Schema::dropIfExists('articles');
    }

    /**
     * マイグレーションの逆操作を実行し、存在する場合は 'articles' テーブルを削除します。
     *
     * このメソッドは、up() メソッドで行われた変更を取り消すために使用されます。
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
