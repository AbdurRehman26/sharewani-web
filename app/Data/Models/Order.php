<?php

namespace App\Data\Models;

class Order extends BaseModel
{
    const STATUSES = [
        0 => 'pending',
        1 => 'accepted',
        -1 => 'rejected'
    ];

    public $searchables = [
        'user_id',
        'id'
    ];
}
