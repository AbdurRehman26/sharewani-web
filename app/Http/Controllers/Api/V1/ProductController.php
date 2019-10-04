<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\Repositories\ProductRepository;
use Kazmi\Http\Controllers\ApiResourceController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class ProductController extends ApiResourceController{
    
    public $_repository;

    public function __construct(ProductRepository $repository){
        $this->_repository = $repository;
    }

    public function rules($value=''){
        $rules = [];

        if($value == 'store'){
            
            $rules['category'] =  'required';
            $rules['event'] =  'required';
            $rules['title'] =  'required';
            $rules['original_price'] =  'required';
            $rules['number_of_items'] =  'required';

        }

        if($value == 'update'){

            $rules['id'] =  'required';

        }


        if($value == 'destroy'){

            $rules['id'] =  'required';

        }

        if($value == 'show'){

            $rules['id'] =  'required';

        }

        if($value == 'index'){
         
            $rules['pagination'] =  'nullable|in:true,false';

        }

        return $rules;
    
    }

    public function input($value=''){

        $input = request()->only('id', 'category', 'number_of_items', 'original_price', 'event', 'images', 'title' , 'pagination', 'dashboard_stats');

        $input['user_id'] = request()->user()->id;
        
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

        //Create single record
    public function store(Request $request)
    {   
        $request->request->add(['method_type' => 'store']);

        $rules = $this->rules(__FUNCTION__);
        $input = $this->input(__FUNCTION__);
        
        $messages = $this->messages(__FUNCTION__);

        $this->validate($request, $rules, $messages);
        
        unset($input['category'], $input['event']);

        $data = $this->_repository->create($input);

        $this->associateWithEventAndCategory($data);

        $data = $this->_repository->findById($data->id, true);

        $output = ['data' => $data, 'message' => $this->responseMessages(__FUNCTION__)];
        
        // HTTP_OK = 200;

        return response()->json($output, Response::HTTP_OK);

    }


    public function associateWithEventAndCategory($product)
    {
        $date = \Carbon\Carbon::now()->toDateTimeString();

        $productEventData[] = [
            'product_id' => $product->id,
            'event_id' => request()->event,
            'created_at' => $date
        ];

        $productCategoryData[] = [
            'product_id' => $product->id,
            'category_id' => request()->category,
            'created_at' => $date
        ];
    
        \App\Data\Models\ProductCategory::insertOnDuplicateKey($productCategoryData);
        \App\Data\Models\ProductEvent::insertOnDuplicateKey($productEventData);

        return true;

    }

}