<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\ItemController;
use App\Http\Controllers\Mobile\AssetController;
use App\Http\Controllers\Mobile\ProductController;
use App\Http\Controllers\Mobile\ProjectController;
use App\Http\Controllers\Mobile\LoginController;
use App\Http\Controllers\Mobile\MaintenanceController;
use App\Http\Controllers\Mobile\RequestMaterialController;


Route::post('login',[LoginController::class,'loginProcess']);

Route::group(['middleware' => ['auth:api','CustomerPermissionAPI']], function () {

	Route::post('logout', [LoginController::class,'logoutProcess']);

	Route::post('updatePassword', 'Api\LoginController@updatePassword');
});

//Product
Route::get('productList',[ProductController::class,'getProductList']);
Route::get('mobile_site_inventory',[ItemController::class,'SiteItemsInventory']);


// Project
Route::get('projectListById/{employeeid}',[ProjectController::class,'getProjectListByid']);
Route::apiResource('project', ProjectController::class);
Route::post('report_task_store',[ProjectController::class,'storeReportTask']);
Route::get('task_report_list_by_employee/{employee}',[ProjectController::class,'getAllListByID']);

//Assest
Route::get('asset', [AssetController::class, 'getAsset']);
Route::get('searchAsset',[AssetController::class,'searchAsset']);

//Maintenance
Route::get('room_building', [MaintenanceController::class, 'getBuildingRoomData']);
Route::post('request_store', [MaintenanceController::class, 'storeRequest']);
Route::post('report_maintenance_store',[MaintenanceController::class,'storeReport']);
Route::get('reportReqMaintainList/{reqMaintain}',[MaintenanceController::class,'getList']);
Route::get('request_list', [MaintenanceController::class, 'getRequestList']);
Route::post('request_list_by_employeeID',[MaintenanceController::class,'getRequestListByEmployeeID']);


//RequestMaterial
Route::post('requestProductStore',[RequestMaterialController::class,'storeRequestProduct']);
Route::get('requestProductList',[RequestMaterialController::class,'getRequestMaterialList']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

