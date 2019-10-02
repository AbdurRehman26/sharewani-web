<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\Order;

class OrderRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of Order Class.
     *
     * @var object
     * @access public
     *
     **/
    public $model;

    /**
     *
     * This is the prefix of the cache key to which the
     * App\Data\Repositories data will be stored
     * App\Data\Repositories Auto incremented Id will be append to it
     *
     * Example: Order-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'Order';
    protected $_cacheTotalKey = 'total-Order';

    public function __construct(Order $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
