<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\Product;

class ProductRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of Product Class.
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
     * Example: Product-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'Product';
    protected $_cacheTotalKey = 'total-Product';

    public function __construct(Product $model)
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
        
        $data->category = app('CategoryRepository')->findById($data->category_id);
        
        $data->event = app('EventRepository')->findById($data->event_id);
        
        $data->formatted_created_at = \Carbon\Carbon::parse($data->created_at)->diffForHumans();

        return $data;
    }


}
