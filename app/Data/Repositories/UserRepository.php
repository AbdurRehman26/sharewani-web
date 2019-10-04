<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Laravue\Models\User;
use Illuminate\Support\Facades\Cache;

class UserRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of User Class.
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
     * Example: User-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'User';
    protected $_cacheTotalKey = 'total-User';

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }


        /**
     *
     * This method will fetch total models
     * and will return output back to client as json
     *
     * @access public
     * @return integer
     *
     * @author Usaama Effendi <usaamaeffendi@gmail.com>
     *
     **/
    public function findTotalByCriteria($criteria = false, $refresh = false) {

        $total = Cache::get($this->_cacheTotalKey);
        if ($total == NULL || $refresh == true) {
            $total = $this->model->count();
            Cache::forever($this->_cacheTotalKey, $total);
        }
        return $total;
    }
}
