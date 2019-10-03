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
    
        $data->categories = $this->model->join('product_categories', function($join){
            
            $join->on('products.id' , 'product_categories.product_id');
        
        })->join('categories', function($join){

            $join->on('categories.id' , 'product_categories.category_id');

        })
        ->where('products.id' , $data->id)
        ->select('categories.name', 'categories.id')
        ->get();


        $data->events = $this->model->join('product_events', function($join){
            
            $join->on('products.id' , 'product_events.product_id');
        
        })->join('events', function($join){

            $join->on('events.id' , 'product_events.event_id');

        })
        ->where('events.id' , $data->id)
        ->select('events.name', 'events.id')
        ->get();

        $data->formatted_created_at = \Carbon\Carbon::parse($data->created_at)->diffForHumans();

        return $data;
    }


}