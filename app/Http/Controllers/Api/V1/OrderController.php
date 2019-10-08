<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\Repositories\OrderRepository;
use Kazmi\Http\Controllers\ApiResourceController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class OrderController extends ApiResourceController
{

    public $_repository;

    public function __construct(OrderRepository $repository)
    {
        $this->_repository = $repository;
    }

    public function rules($value = '')
    {
        $rules = [];

        if ($value == 'store') {
            $rules['product_id'] =  'required';
            $rules['from_date'] =  'required';
            $rules['to_date'] =  'required';

        }

        if ($value == 'update') {
            $rules['id'] =  'required';
        }


        if ($value == 'destroy') {
            $rules['id'] =  'required';

        }

        if ($value == 'show') {
            $rules['id'] =  'required';

        }

        if ($value == 'index') {
            $rules['pagination'] =  'nullable|in:true,false';

        }

        return $rules;
    }

    public function input($value = '')
    {
        \Log::info('here');
        $input = request()->only('id', 'product_id', 'from_date', 'to_date', 'number_of_items');
        $input['user_id'] = request()->user() ?? null;

        return $input;
    }

    public function itemCount(Request $request)
    {
        $data = $this->_repository->findTotal();

        $output = [
                'data' => $data,
        ];

        // HTTP_OK = 200;

        return response()->json($output, Response::HTTP_OK);
    }

}
