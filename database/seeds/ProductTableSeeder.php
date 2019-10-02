<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
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

        $categoryId = \App\Data\Models\Category::first()['id'];
        $eventId = \App\Data\Models\Event::first()['id'];
        $userId = \App\Laravue\Models\User::first()['id'];

        $imagesArray = config('dummyImages');

        shuffle($imagesArray);

        $images = array_slice($imagesArray, 0, 3);

        $data = [
            [
            'title' => 'Black Sherwani',
            'description' => $faker->text,
            'category_id' => $categoryId,
            'event_id' => $eventId,
            'user_id' => $userId,
            'images' => json_encode($images),
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => NULL
          ]
        ];
        
        \App\Data\Models\Product::insertOnDuplicateKey($data);


}
}
