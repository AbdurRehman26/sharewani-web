<?php

use Illuminate\Http\Request;
use \App\Laravue\Faker;
use \App\Laravue\JsonResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function () {
    
    Route::post('auth/login', 'AuthController@login');
    
    Route::group(['middleware' => 'auth:api'], function () {
    
        Route::get('auth/user', 'AuthController@user');
        Route::post('auth/logout', 'AuthController@logout');
    
    

    Route::get('product_count', 'Api\V1\ProductController@itemCount');
    Route::resource('product', 'Api\V1\ProductController')->except([
                 'edit'
    ]);

    Route::resource('category', 'Api\V1\CategoryController')->except([
                 'edit'
    ]);

    Route::get('order_count', 'Api\V1\OrderController@itemCount');
    Route::resource('order', 'Api\V1\OrderController')->except([
                 'edit'
    ]);

    Route::resource('event', 'Api\V1\EventController')->except([
                 'edit'
    ]);

    Route::resource('role', 'Api\V1\RoleController')->except([
                 'edit'
    ]);


    Route::post('file/upload', 'Api\V1\FileUploadController@upload')->name("file.upload");
    Route::post('file/remove', 'Api\V1\FileUploadController@remove')->name("file.remove");


    });

    Route::apiResource('users', 'UserController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_USER_MANAGE);
    
    Route::get('users/{user}/permissions', 'UserController@permissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    
    Route::get('user_count', 'Api\V1\UserController@itemCount');

    Route::put('users/{user}/permissions', 'UserController@updatePermissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    
    Route::apiResource('roles', 'RoleController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    
    Route::get('roles/{role}/permissions', 'RoleController@permissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    
    Route::apiResource('permissions', 'PermissionController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);

    // Fake APIs
    Route::get('/table/list', function () {
        $rowsNumber = mt_rand(20, 30);
        $data = [];
        for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
            $row = [
                'author' => Faker::randomString(mt_rand(5, 10)),
                'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
                'id' => mt_rand(100000, 100000000),
                'pageviews' => mt_rand(100, 10000),
                'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
                'title' => Faker::randomString(mt_rand(20, 50)),
            ];

            $data[] = $row;
        }

        return response()->json(new JsonResponse(['items' => $data]));
    });
    

});
