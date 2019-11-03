<?php

use App\Laravue\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        /* Required Seeders && Default Options */
        $this->call(GlobalSettingTypeTableSeeder::class);
        $this->call(FabricAgeTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(ColorTableSeeder::class);
        $this->call(BrandTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(SizeTableSeeder::class);


        /* Required Seeders */

        $this->call(UsersTableSeeder::class);

        /* Extra Populated Data */

//        $this->call(DummyDataTableseeder::class);
    }
}
