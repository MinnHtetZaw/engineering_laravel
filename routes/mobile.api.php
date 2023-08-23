<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\MobileItemController;
use App\Http\Controllers\Mobile\AssetController;
use App\Http\Controllers\Mobile\ProductController;
use App\Http\Controllers\Mobile\MobileProjectController;
use App\Http\Controllers\Mobile\LoginController;
use App\Http\Controllers\Mobile\MobileMaintenanceController;
use App\Http\Controllers\Mobile\RequestMaterialController;


Route::post('login',[LoginController::class,'loginProcess']);

Route::group(['middleware' => ['auth:api','CustomerPermissionAPI']], function () {

	Route::post('logout', [LoginController::class,'logoutProcess']);

	Route::post('updatePassword', 'Api\LoginController@updatePassword');
});

//Product
Route::get('productList',[MobileItemController::class,'getProductList']);
Route::post('mobile_site_inventory',[MobileItemController::class,'SiteItemsInventory']);
Route::get('delivery_order',[MobileItemController::class,'siteDeliveryOrder'])->name('mobile#DO');
Route::post('delivery_order/receive',[MobileItemController::class,'receiveOrder']);

// Project
Route::get('projectListById/{employeeid}',[MobileProjectController::class,'getProjectListByid']);
Route::apiResource('project', MobileProjectController::class);
Route::post('report_task_store',[MobileProjectController::class,'storeReportTask']);
Route::get('task_report_list_by_employee/{employee}',[MobileProjectController::class,'getAllListByID']);

//Assest
Route::get('asset', [MobileAssetController::class, 'getAsset']);
Route::get('searchAsset',[MobileAssetController::class,'searchAsset']);

//Maintenance
Route::get('room_building', [MobileMaintenanceController::class, 'getBuildingRoomData']);
Route::post('request_store', [MobileMaintenanceController::class, 'storeRequest']);
Route::post('report_maintenance_store',[MobileMaintenanceController::class,'storeReport']);
Route::get('reportReqMaintainList/{reqMaintain}',[MobileMaintenanceController::class,'getList']);
Route::get('request_list', [MobileMaintenanceController::class, 'getRequestList']);
Route::post('request_list_by_employeeID',[MobileMaintenanceController::class,'getRequestListByEmployeeID']);


//RequestMaterial
Route::post('requestProductStore',[RequestMaterialController::class,'storeRequestProduct']);
Route::get('requestProductList',[RequestMaterialController::class,'getRequestMaterialList']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

