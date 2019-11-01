<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\GlobalSetting;
use App\Traits\AbstractMethods;

class GlobalSettingRepository extends AbstractRepository implements RepositoryContract
{
    use AbstractMethods;    
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

        /**
     *
     * This method will fetch single model
     * and will return output back to client as json
     *
     * @access public
     * @return mixed
     *
     * @author Usaama Effendi <usaamaeffendi@gmail.com>
     *
     **/
    public function findById($id, $refresh = false, $details = false, $encode = true) {
        
        $data = parent::findById($id, $refresh, $details, $encode);
    
        return $data;
    
    }


    /**
     *
     * This method will fetch all exsiting models
     * and will return output back to client as json
     *
     * @access public
     * @param bool $pagination
     * @param int $perPage
     * @param array $input
     * @return mixed
     *
     * @author Usaama Effendi <usaamaeffendi@gmail.com>
     *
     */
    public function findByAll($pagination = false, $perPage = 10, array $input = [])
    {
        $this->builder = $this->searchCriteria($input);

        $this->builder = $this->builder->orderBy('is_active', 'DESC');

        return parent::findByAll($pagination, $perPage, $input);
    }


    public function insertOrUpdate($updateData)
    {
        $data = $this->findByAttribute('key', $updateData['key']);
            
        if($data){
            $updateData['id'] = $data->id;
            return $this->update($updateData);
        }

        return $this->create($updateData);
    }
}
