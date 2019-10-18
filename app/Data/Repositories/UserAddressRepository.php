<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\UserAddress;

class UserAddressRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of UserAddress Class.
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
     * Example: UserAddress-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'UserAddress';
    protected $_cacheTotalKey = 'total-UserAddress';

    public function __construct(UserAddress $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
