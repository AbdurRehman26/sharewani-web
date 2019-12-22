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
        $data = [];

        $brands = [
            'Bissino',
            'Junoon',
            'Bonanza',
            'Gul Ahmed',
            'Moosaa Jee',
            'Maaz Jee',
            'J.',
            'Khaadi',
            'Kapraay',
            'Eden Robe',
            'Cotton & Cotton',
            'Lawrencepur',
            'Custom'
        ];

        foreach ($brands as $brand) {
            $data[] = [
                'name' => $brand,
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => null
            ];
        }

        \App\Data\Models\Brand::insertOnDuplicateKey($data, ['name']);
    }
}
