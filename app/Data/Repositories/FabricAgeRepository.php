<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\FabricAge;

class FabricAgeRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of FabricAge Class.
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
     * Example: FabricAge-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'FabricAge';
    protected $_cacheTotalKey = 'total-FabricAge';

    public function __construct(FabricAge $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
