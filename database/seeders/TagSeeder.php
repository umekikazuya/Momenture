<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * タグの初期データをデータベースに登録する。
     *
     * このメソッドは、'PHP'、'Laravel'、および 'DDD' のタグを Tag モデルを通じてデータベースに順次登録します。
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
