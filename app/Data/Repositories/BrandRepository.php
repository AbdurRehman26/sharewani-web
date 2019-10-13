<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\Brand;

class BrandRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of Brand Class.
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
     * Example: Brand-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'Brand';
    protected $_cacheTotalKey = 'total-Brand';

    public function __construct(Brand $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
