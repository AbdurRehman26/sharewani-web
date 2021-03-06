<?php

namespace App\Data\Repositories;

use Kazmi\Data\Contracts\RepositoryContract;
use Kazmi\Data\Repositories\AbstractRepository;
use App\Data\Models\Order;
use App\Traits\AbstractMethods;

class OrderRepository extends AbstractRepository implements RepositoryContract
{
    use AbstractMethods;
    /**
     *
     * These will hold the instance of Order Class.
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
     * Example: Order-1
     *
     * @var string
     * @access protected
     *
     **/

    protected $_cacheKey = 'Order';
    protected $_cacheTotalKey = 'total-Order';

    public function __construct(Order $model)
    {
        $this->model = $model;
        $this->builder = $model;
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
        return parent::findByAll($pagination, $perPage, $input);
    }

    /**
     *
     * This method will create a new model
     * and will return output back to client as json
     *
     * @access public
     * @param array $data
     * @return mixed
     *
     * @author Usaama Effendi <usaamaeffendi@gmail.com>
     *
     */
    public function create(array $data = [])
    {

        $data['deleted_at'] = null;
        $order = Order::insertOnDuplicateKey($data);
        $retRetId = \DB::getPdo()->lastInsertId();
        return $this->findById($retRetId);
    }
    /**
     *
     * This method will fetch single model
     * and will return output back to client as json
     *
     * @access public
     * @param $id
     * @param bool $refresh
     * @param bool $details
     * @param bool $encode
     * @return mixed
     *
     * @author Usaama Effendi <usaamaeffendi@gmail.com>
     *
     */
    public function findById($id, $refresh = false, $details = false, $encode = true)
    {
        $data = parent::findById($id, $refresh, $details, $encode);

        $data->user = app('UserRepository')->findById($data->user_id);

        $data->product = app('ProductRepository')->findById($data->product_id);

        $data->address = app('UserAddressRepository')->findById($data->address_id);

        $data->formatted_created_at = \Carbon\Carbon::parse($data->created_at)->diffForHumans();

        $data->order_status = Order::STATUSES[$data->status];

        return $data;
    }


    public function updateOrder($input)
    {
        $order = parent::findById($input['order_id']);

        $input['product_id'] = $order->product_id;
        $input['from_date'] = $order->from_date;
        $input['to_date'] = $order->to_date;

        $acceptedOrder = $this->validateOrderDate($input, false, 1);

        if($acceptedOrder){
            return false;
        }

        $updateData['id'] = $order->id;
        $updateData['status'] = 1;

        return $this->update($updateData);


    }


    public function validateOrderDate($input, $all = false, $status = 1)
    {
        $orderBuilder = $this->model->where('product_id', $input['product_id']);

        if (!empty($input['order_id'])) {
            $orderBuilder = $orderBuilder->where('id', '!=', $input['order_id']);
        }
        $orderBuilder = $orderBuilder->where(function ($where) use ($input, $status)  {
            $where->where(function ($childWhere) use ($input, $status) {
                $childWhere->where('from_date', '<=', date($input['from_date']))
                    ->where('to_date', '>=', date($input['from_date']))
                    ->where('status', $status);
            })->orWhere(function ($childWhere) use ($input, $status) {
                $childWhere->where('from_date', '<=', date($input['to_date']))
                    ->where('to_date', '>=', date($input['to_date']))
                    ->where('status', $status);
            });
        });

        if (!$all) {
            return $orderBuilder->first();
        }

        return $orderBuilder->pluck('id')->toArray();
    }


    public function validateCollidingOrder($input, $all = false)
    {
        $orderBuilder = $this->model->where('product_id', $input['product_id']);

        if (!empty($input['order_id'])) {
            $orderBuilder = $orderBuilder->where('id', '!=', $input['order_id']);
        }
        $orderBuilder = $orderBuilder->where(function ($where) use ($input) {
            $where->where(function ($childWhere) use ($input) {
                $childWhere->where('from_date', '<=', date($input['from_date']))
                    ->where('to_date', '>=', date($input['from_date']))
                    ->where('status', '!=', -1);
            })->orWhere(function ($childWhere) use ($input) {
                $childWhere->where('from_date', '<=', date($input['to_date']))
                    ->where('to_date', '>=', date($input['to_date']))
                    ->where('status', '!=', -1);
            });
        });

        if (!$all) {
            return $orderBuilder->first();
        }

        return $orderBuilder->pluck('id')->toArray();
    }


    public function calculateRent($input, $dont = true)
    {
        $orderConstants = !empty(app('config')['constants']['order']) ? app('config')['constants']['order'] : null;

        if (!$orderConstants) {
            return false;
        }

        $product = app('ProductRepository')->findById($input['product_id'], false, ['dont' => true]);
        $productPrice = (int) $product->original_price;

        $age = $product->fabric_age->value;

        $rent = (
                ($productPrice * $orderConstants['base_factor'] *
                (10/$orderConstants['condition_factor'])) -
            ($productPrice * $age * $orderConstants['age_discount'])) *
            (1- $orderConstants['promo_discount']);
        return $rent;
    }

    public function collidingOrders($input)
    {
        $order = \App\Data\Models\Order::find($input['order_id']);
        $input['from_date'] = $order['from_date'];
        $input['to_date'] = $order['to_date'];
        $input['product_id'] = $order['product_id'];
        $input['order_id'] = $order['id'];

        $allOrdersId = $this->validateCollidingOrder($input, true);
        $input['id'] = $allOrdersId;
        unset($input['user_id']);
        return $this->findByAll(false, 20, $input)['data'];
    }

}
