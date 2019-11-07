<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\Repositories\GlobalSettingRepository;
use Kazmi\Http\Controllers\ApiResourceController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class GlobalSettingController extends ApiResourceController{
    
    public $_repository;

    public function __construct(GlobalSettingRepository $repository){
        $this->_repository = $repository;
    }

    public function rules($value=''){
        $rules = [];

        if($value == 'store'){
            
            $rules['key'] =  'required';
            $rules['value'] =  'required';
            $rules['type'] =  'required';

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
        $input = request()->only('id', 'key', 'value', 'type', 'is_active');
        
        return $input;
    }

    //Create single record
    public function store(Request $request)
    {
        $request->request->add(['method_type' => 'store']);

        $rules = $this->rules(__FUNCTION__);
        $input = $this->input(__FUNCTION__);

        $messages = $this->messages(__FUNCTION__);
        
        $this->validate($request, $rules, $messages);

        $data = $this->_repository->create($input);

        $output = ['data' => $data, 'message' => $this->responseMessages(__FUNCTION__)];

        // HTTP_OK = 200;

        return response()->json($output, Response::HTTP_OK);

    }

    public function updateItemByKey($settingKey, Request $request)
    {
        $settingType = app('GlobalSettingTypeRepository')->findByAttribute('name' , $settingKey);

        # code...
        $updateData = $this->input();
        $updateData['type'] = $settingType->id;
        $updateData['key'] = $settingKey;
        $updateData['is_active'] = 1;
        
        $globalSettings = config('constants')['global_settings'];
        
        if($globalSettings[$settingKey] && (int) $globalSettings[$settingKey]['limit'] == 1){
            $this->_repository->updateMultiple(['type' => $settingType->id], ['is_active' => 0]);
        }


        $data = $this->_repository->insertOrUpdate($updateData);

        $output = ['data' => $data, 'message' => $this->responseMessages(__FUNCTION__)];

        // HTTP_OK = 200;

        return response()->json($output, Response::HTTP_OK);
    
    }

    public function getItemByKey($key)
    {

        $criteria = ['key' =>  $key, 'is_active' => 1];

        $data = $this->_repository->findByCriteria($criteria);
    
        $output = ['data' => $data, 'message' => $this->responseMessages(__FUNCTION__)];

        // HTTP_OK = 200;

        return response()->json($output, Response::HTTP_OK);

    }
}