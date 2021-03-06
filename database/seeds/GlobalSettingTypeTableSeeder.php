<?php

use Illuminate\Database\Seeder;

class GlobalSettingTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = \Carbon\Carbon::now()->toDateTimeString();

        $data = [];

        $settings = [
            'main_logo',
            'home_main_banner',
            'home_headings',
            'footer',
            'terms_of_services',
            'privacy_policy'
        ];

        foreach ($settings as $setting) {
            $data[] = [
                'name' => $setting,
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => null
            ];
        }

        \App\Data\Models\GlobalSettingType::insertOnDuplicateKey($data, ['name']);
    }
}
