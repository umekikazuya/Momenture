<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * データベースに初期タグを登録する。
     *
     * このメソッドは Tag モデルを利用して、'PHP', 'Laravel', 'DDD' の 3 つのタグを作成し、
     * データベースに登録します。
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
