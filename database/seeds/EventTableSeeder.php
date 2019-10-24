<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $date = Carbon::now()->toDateTimeString();

        $data = [
            [
            'name' => 'Shaadi',
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => NULL
            ],
            [
            'name' => 'Mehendi',
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => NULL
            ],
            [
            'name' => 'Other',
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => NULL
            ],
        ];


        \App\Data\Models\Event::insertOnDuplicateKey($data, ['name']);


}
}
