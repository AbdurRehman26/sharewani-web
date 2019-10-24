<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $date = Carbon::now()->toDateTimeString();

        $brands = [
            'Bonanza',
            'Gul Ahmed',
            'Moosaa Jee',
            'Maaz Jee',
            'Junaid Jamshaid',
            'Khaadi',
            'Kapraay',
            'Eden Robe',
            'Cotton & Cotton'
        ];

        foreach ($brands as $brand){
            $data[] = [
                'name' => $brand,
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ];
        }

        \App\Data\Models\Brand::insertOnDuplicateKey($data, ['name']);



    }
}
