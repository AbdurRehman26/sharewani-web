<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\ContactUs;

class ContactUsRepository extends AbstractRepository implements RepositoryContract
{
    /**
     *
     * These will hold the instance of ContactUs Class.
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
     * Example: ContactUs-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'ContactUs';
    protected $_cacheTotalKey = 'total-ContactUs';

    public function __construct(ContactUs $model)
    {
        $this->model = $model;
        $this->builder = $model;

    }
}
