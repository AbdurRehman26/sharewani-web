<?php

use Illuminate\Database\Seeder;

class DummyDataTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(ProductTableSeeder::class);
        $this->call(AssociateProductsTableSeeder::class);
        $this->call(OrderTableSeeder::class);
        $this->call(ContactUsTableSeeder::class);
        $this->call(UserAddressTableSeeder::class);
    }
}
