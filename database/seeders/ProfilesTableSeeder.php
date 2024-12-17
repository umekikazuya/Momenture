<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // JSONファイルを読み込み
        $data = File::get(database_path('seeders/dynamodb_data.json'));
        $items = json_decode($data, true)['Items'];

        foreach ($items as $item) {
            Profile::create([
                'github' => $item['github']['S'] ?? null,
                'qiita' => $item['qiita']['S'] ?? null,
                'address' => $item['address']['S'] ?? null,
                'zenn' => $item['zenn']['S'] ?? null,
                'skill' => json_encode(array_map(fn ($skill) => $skill['S'], $item['skill']['L'] ?? [])),
                'display_name' => $item['display_name']['S'] ?? null,
                'display_short_name' => $item['display_short_name']['S'] ?? null,
                'from' => $item['from']['S'] ?? null,
                'likes' => json_encode(array_map(fn ($like) => $like['S'], $item['like']['L'] ?? [])),
                'summary_introduction' => $item['summary_introduction']['NULL'] ?? null,
                'introduction' => $item['introduction']['S'] ?? null,
                'job' => $item['job']['S'] ?? null,
            ]);
        }
    }
}
