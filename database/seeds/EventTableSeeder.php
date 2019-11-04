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
            'name' => 'Wedding',
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => null
            ],
        ];


        \App\Data\Models\Event::insertOnDuplicateKey($data, ['name']);


}
}
