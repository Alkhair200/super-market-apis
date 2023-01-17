<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Companies;

class CompanyTableSeeder extends Seeder
{

    public function run()
    {
        $data = ['companty1','companty2'];
        foreach ($data as $value) {
            Companies::create([
                'name' => $value,
            ]);
        }        
    }
}
