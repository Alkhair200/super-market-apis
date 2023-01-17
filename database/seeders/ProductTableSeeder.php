<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;

class ProductTableSeeder extends Seeder
{
    
    public function run()
    {
        $data =['مأكولات','مشروبات'];
        foreach ($data as $value) {
            Products::create([
                'name' => $value,
            ]);
        }

    }
}
