<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Places;

class PlaceTableSeeder extends Seeder
{
    public function run()
    {
        $data = ['palce 1','place 2'];
        foreach ($data as $value) {
            Places::create([
                'name' => $value,
            ]);
        }          
    }
}
