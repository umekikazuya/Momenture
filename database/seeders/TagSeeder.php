<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
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
