<?php

namespace App\Data\Models;

class Product extends BaseModel
{
    //

    protected $casts = [
        'images' => 'array'
    ];

    public $searchables = [
        'brand_id', 'color_id', 'fabric_age_id', 'size_id',
    ];

}
