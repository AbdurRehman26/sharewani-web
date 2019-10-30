<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\GlobalSettingType;

class GlobalSettingTypeRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of GlobalSettingType Class.
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
     * Example: GlobalSettingType-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'GlobalSettingType';
    protected $_cacheTotalKey = 'total-GlobalSettingType';

    public function __construct(GlobalSettingType $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
