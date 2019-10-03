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


        /**
     *
     * This method will fetch single model
     * and will return output back to client as json
     *
     * @access public
     * @return mixed
     *
     * @author Usaama Effendi <usaamaeffendi@gmail.com>
     *
     **/
    public function findById($id, $refresh = false, $details = false, $encode = true) {

        $data = parent::findById($id, $refresh, $details, $encode);
        
        $data->user = app('UserRepository')->findById($data->user_id);
        
        $data->product = app('ProductRepository')->findById($data->product_id);
    
        $data->formatted_created_at = \Carbon\Carbon::parse($data->created_at)->diffForHumans();
    
        $data->order_status = Order::STATUSES[$data->status];
    
        return $data;
    }


}
