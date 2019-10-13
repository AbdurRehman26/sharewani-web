<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Product extends Model
{
    //
	use  InsertOnDuplicateKey;

    protected $casts = [
        'images' => 'array'
    ];
}
