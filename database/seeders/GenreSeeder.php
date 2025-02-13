<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            [
                'name' => 'Dance'
            ],
            [
                'name' => 'Drive'
            ],
            [
                'name' => 'Rain'
            ],
            [
                'name' => 'Hip Hop'
            ],
            [
                'name' => 'Party'
            ],
            [
                'name' => 'Bhakti'
            ],
            [
                'name' => '90s'
            ],
            [
                'name' => '2000s'
            ],
        ];

        foreach ($genres as $row)
        {
            Genre::create($row);
        }
    }
}
