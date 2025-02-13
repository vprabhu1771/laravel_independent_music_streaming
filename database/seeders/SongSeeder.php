<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Genre;
use App\Models\Brand;
use App\Models\Song;


class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $bhakti = Genre::where('name', 'Bhakti')->first();

        $avm_music = Brand::where('name', 'AVM Music')->first();
        $think_music = Brand::where('name', 'Think Music')->first();
        $sony_music = Brand::where('name', 'Sony Music')->first();

        $songs = [
            [
                'name' => 'Azhagellam Murugane',
                'genre_id' => $bhakti->id,
                'brand_id' => $avm_music->id,
            ],
            [
                'name' => 'Vinayagane Vinai Theerapavane',
                'genre_id' => $bhakti->id,
                'brand_id' => $think_music->id,
            ],
            [
                'name' => 'Hara Hara Sivane',
                'genre_id' => $bhakti->id,
                'brand_id' => $sony_music->id,
            ],
        
        ];

        foreach ($songs as $row)
        {
            Song::create($row);
        }
    }
}