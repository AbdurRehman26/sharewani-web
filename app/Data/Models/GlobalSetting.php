<?php

namespace App\Data\Models;

class GlobalSetting extends BaseModel
{
    protected $casts = [
        'value' => 'array'
    ];

    public $searchables = [
    	'key',
    	'is_active'
    ];

}
