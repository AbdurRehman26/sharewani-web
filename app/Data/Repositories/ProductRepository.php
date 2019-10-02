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
}
