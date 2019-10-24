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


        $imagesArray = config('dummyImages');


        for ($i = 0; $i < 200; $i++) {

            shuffle($imagesArray);

            $images = array_slice($imagesArray, 0, 3);

            $data[] = [
                'title' => "$faker->companySuffix Sherwani",
                'description' => $faker->text,
                'user_id' => \App\Laravue\Models\User::inRandomOrder()->first()['id'],
                'images' => json_encode($images),
                'number_of_items' => 1,
                'original_price' => 1000,
                'size_id' => \App\Data\Models\Size::inRandomOrder()->first()['id'],
                'brand_id' => \App\Data\Models\Brand::inRandomOrder()->first()['id'],
                'color_id' => \App\Data\Models\Color::inRandomOrder()->first()['id'],
                'fabric_age_id' => \App\Data\Models\FabricAge::inRandomOrder()->first()['id'],
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ];

        };

        \App\Data\Models\Product::insertOnDuplicateKey($data);

}
}
