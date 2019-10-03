<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Order extends Model
{
    //
	use  InsertOnDuplicateKey;

	const STATUSES = [
		0 => 'Pending',
		1 => 'Accepted',
		-1 => 'Rejected'
	];
}
