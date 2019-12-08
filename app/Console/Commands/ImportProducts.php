<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from a file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $date = \Carbon\Carbon::now()->toDateTimeString();

        $fileName = 'ProductsData.csv';
        $filePath = storage_path('app/public/'.$fileName);

        $array = Excel::toArray(new ProductImport, $filePath);

        $event = \App\Data\Models\Event::first();

        $category = \App\Data\Models\Category::where('name', 'Sherwaani')->first();

        foreach ($array[0] as $key => $row) {
            if ($key) {
                $images = [];
                for ($i = 1; $i <= 3; $i++) {
                    $images[] = "$key-$i.jpg";
                }

                $fabricAge = app('FabricAgeRepository')->findByAttribute('name', $row[4]);
                $color = app('ColorRepository')->findByAttribute('name', $row[7]);
                $brand = app('BrandRepository')->findByAttribute('name', $row[8]);
                $fabricBrand = app('BrandRepository')->findByAttribute('name', $row[12]);
                $sizeFeatures = explode(', ', $row[6]);
                $size = app('SizeRepository')->findByAttribute('code', $row[5]);

                $row[9] = str_replace('.0', '', $row[9]);
                $row[9] = '0'. $row[9];

                $vendor = app('UserRepository')->findByAttribute('phone_number', $row[9]);

                if (!$vendor) {
                    $userData = [
                        'phone_number' => $row[9],
                        'name' => $row[10],
                    ];
                    $vendor = app('UserRepository')->create($userData);
                }

                $user = app('UserRepository')->findByAttribute('name', $row[13]);

                $input = [
                    'description' => $row[1],
                    'images' => $images,
                    'original_price'=> $row[2],
                    'fabric_age_id' => $fabricAge->id,
                    'color_id' => $color->id,
                    'brand_id' => $brand->id,
                    'fabric_brand_id' => $fabricBrand->id,
                    'size_id' => $size->id,
                    'size_length' => $sizeFeatures[0],
                    'size_chest' => $sizeFeatures[1],
                    'size_tummy' => $sizeFeatures[2],
                    'size_sleeves' => $sizeFeatures[3],
                    'size_collar' => $sizeFeatures[4],
                    'vendor_id' => $vendor->id,
                    'user_id' => $user->id,
                    'created_at' => $date,
                    'updated_at' => $date,
                ];


                $product = app('ProductRepository')->create($input);


                $productEventData = [
                'product_id' => $product->id,
                'event_id' => $event['id'],
                'created_at' => $date,
                'updated_at' => $date
                ];

                $productCategoryData = [
                'product_id' => $product->id,
                'category_id' => $category['id'],
                'created_at' => $date,
                'updated_at' => $date
                ];


                \App\Data\Models\ProductCategory::insertOnDuplicateKey($productCategoryData);
                \App\Data\Models\ProductEvent::insertOnDuplicateKey($productEventData);

            }

        }
    }
}
