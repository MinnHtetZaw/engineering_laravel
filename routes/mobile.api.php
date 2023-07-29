<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PhaseTaskController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\BomSupplierController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProjectPhaseController;
use App\Http\Controllers\RegWarehouseController;
use App\Http\Controllers\BillOfMaterialController;
use App\Http\Controllers\BomSupplierGRNController;
use App\Http\Controllers\BomSupplierInvoiceController;
use App\Http\Controllers\BomSupplierProductController;
use App\Http\Controllers\BomSupplierQuotationController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\RequestMaterialController;
use App\Http\Controllers\SaleController;


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

Route::post('login',[LoginController::class,'loginProcess']);

Route::group(['middleware' => ['auth:api','CustomerPermissionAPI']], function () {

	Route::post('logout', [LoginController::class,'logoutProcess']);

	Route::post('updatePassword', 'Api\LoginController@updatePassword');
});

Route::get('request_list', [MaintenanceController::class, 'getRequestList']);
Route::post('request_list_by_employeeID',[MaintenanceController::class,'getRequestListByEmployeeID']);
Route::get('projectListById/{employeeid}',[ProjectController::class,'getProjectListByid']);
Route::get('productList',[ProductController::class,'getProductList']); // Mobile
Route::get('mobile_site_inventory',[ItemController::class,'SiteItemsInventory']);
Route::apiResource('project', ProjectController::class);

// Phase Task

Route::post('report_task_store',[PhaseTaskController::class,'storeReportTask']);
Route::get('task_report_list_by_employee/{employee}',[PhaseTaskController::class,'getAllListByID']);

//Assest
Route::get('asset', [AssetController::class, 'getAsset']);
Route::get('searchAsset',[AssetController::class,'searchAsset']);

//Maintenance
Route::get('room_building', [MaintenanceController::class, 'getBuildingRoomData']);
Route::post('request_store', [MaintenanceController::class, 'storeRequest']);
Route::post('report_maintenance_store',[MaintenanceController::class,'storeReport']);
Route::get('reportReqMaintainList/{reqMaintain}',[MaintenanceController::class,'getList']);

//RequestMaterial
Route::post('requestProductStore',[RequestMaterialController::class,'storeRequestProduct']);
Route::get('requestProductList',[RequestMaterialController::class,'getRequestMaterialList']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

