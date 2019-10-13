<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\Color;

class ColorRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of Color Class.
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
     * Example: Color-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'Color';
    protected $_cacheTotalKey = 'total-Color';

    public function __construct(Color $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
