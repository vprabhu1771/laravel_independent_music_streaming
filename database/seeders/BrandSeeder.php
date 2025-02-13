<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name'=> 'AVM Music'
            ],
            [
                'name'=> 'Think Music'
            ],
            [
                'name'=> 'Sony Music'
            ]
        ];
        
        foreach ($brands as $row) {
            Brand::create($row);
        }
    }
}
