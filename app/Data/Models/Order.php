<?php

namespace App\Data\Models;

class Order extends BaseModel
{
    const STATUSES = [
        0 => 'Pending',
        1 => 'Accepted',
        -1 => 'Rejected'
    ];

    public $searchables = [
        'user_id',
        'id'
    ];
}
