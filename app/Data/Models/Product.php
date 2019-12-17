<?php

namespace App\Data\Models;

class Product extends BaseModel
{
    //

    protected $casts = [
        'images' => 'array'
    ];

    public $searchables = [
        'fabric_brand_id', 'brand_id', 'color_id', 'fabric_age_id', 'size_id',
    ];

}

