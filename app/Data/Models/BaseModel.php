<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    //
    use  InsertOnDuplicateKey, LogsActivity, SoftDeletes;

    protected static $logFillable = true;
}
