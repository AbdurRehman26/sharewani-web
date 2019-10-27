<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FabricAgeTableSeeder extends Seeder
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

        $fabricAges = [
            'New',
            'Less than 6 months',
            'Between 6 and 12 months',
            'Between 12 and 18 months',
            'Between 18 and 24 months',
            'Between 24 and 30 months',
            'Between 30 and 36 months',
            'Older than 36 months'
        ];

        foreach ($fabricAges as $fabricAge) {
            $data[] = [
                'name' => $fabricAge,
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => null
            ];
        }

        \App\Data\Models\FabricAge::insertOnDuplicateKey($data, ['name']);
    }
}
