<?php

namespace App\Data\Models;

class UserAddress extends BaseModel
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address', 'address_secondary', 'nearest_check_point', 'user_id', 'city_id', 'created_at', 'updated_at', 'phone_number'
    ];


    public $searchables = [
    	'user_id'
    ];
}
