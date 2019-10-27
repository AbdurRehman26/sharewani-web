<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $date = Carbon::now()->toDateTimeString();
        $data = [];

        $colors = [
            [
                'code' => '#A52A2A',
                'name' => 'Brown',
            ],
            [
                'code' => '#2D667E',
                'name' => 'Turquoise Dark'
            ],
            [
            'code' => '#195953',
            'name' => 'Turquoise',
            ],
            [
                'code' => '#FFFFFF',
                'name' => 'White',
            ],
            [
                'code' => '#F5F2D0',
                'name' => 'Off White',
            ],
            [
                'code' => '#800000',
                'name' => 'Maroon',
            ],
            [
                'code' => '#F5F5DC',
                'name' => 'Beige',
            ],
            [
                'code' => '#FFFF99',
                'name' => 'Cream',
            ],
            [
                'code' => '#000000',
                'name' => 'Black',
            ],
            [
                'code' => '#808080',
                'name' => 'Grey',
            ],
            [
                'code' => '#C0C0C0',
                'name' => 'Silver',
            ],
            [
                'code' => '#FFD700',
                'name' => 'Gold',
            ],

        ];

        foreach ($colors as $color) {
            $data[] = [
                'name' => $color['name'],
                'code' => $color['code'],
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => null

            ];

        }

        \App\Data\Models\Color::insertOnDuplicateKey($data, ['name']);
    }
}
