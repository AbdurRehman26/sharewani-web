<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\GlobalSetting;

class GlobalSettingRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of GlobalSetting Class.
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
     * Example: GlobalSetting-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'GlobalSetting';
    protected $_cacheTotalKey = 'total-GlobalSetting';

    public function __construct(GlobalSetting $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
