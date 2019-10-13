<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\Category;

class CategoryRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of Category Class.
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
     * Example: Category-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'Category';
    protected $_cacheTotalKey = 'total-Category';

    public function __construct(Category $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
