<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * 初期タグデータをデータベースに登録します。
     *
     * このメソッドは 'PHP', 'Laravel', 'DDD' の各タグを `tags` テーブルに登録します。
     * 各レコードは `Tag` モデルの `create` メソッドを使用して作成されます。
     */
    public function run()
    {
        Tag::create([
            'name' => 'PHP',
        ]);
        Tag::create([
            'name' => 'Laravel',
        ]);
        Tag::create([
            'name' => 'DDD',
        ]);
    }
}
