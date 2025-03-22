<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーション実行時に存在する 'articles' テーブルを削除します。
     *
     * このメソッドは、アップグレード処理の一環としてテーブルが存在する場合に
     * Schema::dropIfExists() を用いて安全に 'articles' テーブルを削除します。
     */
    public function up(): void
    {
        Schema::dropIfExists('articles');
    }

    /**
     * マイグレーションのロールバックを実行する。
     *
     * このメソッドは、articles テーブルが存在する場合に削除し、
     * マイグレーションによる変更を取り消します。
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
