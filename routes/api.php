<?php

use App\Models\BomSupplier;
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
use App\Models\PhaseTask;
use App\Models\Product;

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

Route::apiResource('category', CategoryController::class);
Route::apiResource('sub_category', SubCategoryController::class);
Route::apiResource('brand', BrandController::class);
Route::apiResource('product', ProductController::class);
Route::get('productList',[ProductController::class,'getProductList']); // Mobile
Route::get('product_display',[ProductController::class,'displayProduct']);  // Web Sales Order

Route::apiResource('supplier', SupplierController::class);
Route::apiResource('company', CompanyController::class);
Route::apiResource('item', ItemController::class);
Route::apiResource('regional_warehouse', RegWarehouseController::class);
Route::get('regional_warehouse_products/{id}', [RegWarehouseController::class, 'regWarehouseProducts']);
Route::get('site_items', [ItemController::class, 'SiteItems']);
Route::get('site_items/phase/{id}', [ItemController::class,'SiteItemByPhase']);

Route::get('account_type', [AccountingController::class, 'account_type']);
Route::apiResource('cost_center', CostCenterController::class);
Route::apiResource('currency', CurrencyController::class);
Route::apiResource('accounting', AccountingController::class);
Route::apiResource('project', ProjectController::class);
Route::get('projectListById/{employeeid}',[ProjectController::class,'getProjectListByid']);

// Project Phase
Route::apiResource('phase', ProjectPhaseController::class);
Route::get('phaseList/{id}', [ProjectPhaseController::class,'getPhase']);

//Phase Task
Route::apiResource('task', PhaseTaskController::class);
Route::get('taskList/{id}',[PhaseTaskController::class,'getTask']);
Route::post('report_task_store',[PhaseTaskController::class,'storeReportTask']);
Route::get('reportList/{task}',[PhaseTaskController::class,'getReportList']);
Route::get('task_report_list_by_employee/{employee}',[PhaseTaskController::class,'getAllListByID']);

//product filter (BOM)
Route::post('proj_dep_fil', [ProductController::class, 'department_filter']);
Route::post('proj_cat_fil', [ProductController::class, 'category_filter']);
Route::post('proj_subcat_fil', [ProductController::class, 'subcategory_filter']);
Route::post('proj_brand_fil', [ProductController::class, 'brand_filter']);
Route::apiResource('bom', BillOfMaterialController::class);
// Route::get('bom/{id}',[BillOfMaterialController::class,'getBom']);
Route::get('bomproduct/{bid}/{sid}', [BillOfMaterialController::class, 'supplierproduct']);
Route::get('bomproduct/{id}', [BillOfMaterialController::class, 'bomproduct']);
Route::post('bomproductid', [BillOfMaterialController::class, 'bomproductid']);
Route::post('bomproductqty', [BillOfMaterialController::class, 'bomproductqty']);
Route::post('bomproductspec', [BillOfMaterialController::class, 'bomproductspec']);
Route::post('bomproductviewspec', [BillOfMaterialController::class, 'bomproductviewspec']);
Route::apiResource('bomsupplier', BomSupplierController::class);
Route::apiResource('bomsupplierquotation', BomSupplierQuotationController::class);
Route::post('bomsupplierquotationfile', [BomSupplierQuotationController::class, 'detail']);
Route::get('bomsupplierfil/{id}', [BomSupplierController::class, 'BomSupplierFilter']);
Route::get('bomsupplierproduct/{id}', [BomSupplierProductController::class, 'getBomSupplierProductData']);
Route::post('send/request_email', [BillOfMaterialController::class, 'request_mail']);
Route::post('test', [BillOfMaterialController::class, 'test']);
Route::apiResource('bomsupplierinvoice', BomSupplierInvoiceController::class);
Route::post('bomsupplierinvoicefile', [BomSupplierInvoiceController::class, 'detail']);
Route::post('bomsupplierGRNData_save', [BomSupplierGRNController::class, 'saveGRNData']);
Route::post('grnItem_store', [BomSupplierGRNController::class, 'saveGRNItem']);


Route::post('storeProductData', [AdminController::class, 'storeProductData']);
Route::get('newProductid', [AdminController::class, 'getNewProductId']);
Route::get('incoterm', [AdminController::class, 'getIncotermList']);
Route::post('supplier_data', [AdminController::class, 'saveSupplierData']);
Route::get('pro_detail/{id}', [AdminController::class, 'getProductDetail']);
Route::get('product_compare/{id}', [AdminController::class, 'getProductCompareData']);
Route::get('item_detail/{id}', [AdminController::class, 'getItemDetail']);
Route::get('department', [AdminController::class, 'getDepartmentList']);

//Zone
Route::get('zone', [ZoneController::class, 'getZone']);
Route::post('zone_store', [ZoneController::class, 'store_zone']);

//Shelf
Route::get('shelf', [ShelfController::class, 'getShelf']);
Route::post('shelf_store', [ShelfController::class, 'storeShelf']);

//Level
Route::get('level', [LevelController::class, 'getLevel']);
Route::post('level_store', [LevelController::class, 'storeLevel']);

//Part
Route::get('part', [PartController::class, 'getPartall']);
Route::post('part_store', [PartController::class, 'storePart']);
Route::post('part_edit/{id}', [PartController::class, 'editPart']);
Route::get('part_delete/{id}', [PartController::class, 'deletePart']);


//Assest
Route::get('asset', [AssetController::class, 'getAsset']);
Route::post('asset_store', [AssetController::class, 'storeAsset']);
Route::get('asset/{id}', [AssetController::class, 'getAssetDetail']);
Route::get('searchAsset',[AssetController::class,'searchAsset']);

//Maintenance
Route::get('maintenance', [MaintenanceController::class, 'getMaintenanceData']);
Route::post('maintenance_store', [MaintenanceController::class, 'storeMaintenance']);
Route::get('request_list', [MaintenanceController::class, 'getRequestList']);
Route::get('room_building', [MaintenanceController::class, 'getBuildingRoomData']);
Route::post('request_store', [MaintenanceController::class, 'storeRequest']);
Route::get('request/{id}',[MaintenanceController::class,'getRequestDetail']);
Route::post('request_list_by_employeeID',[MaintenanceController::class,'getRequestListByEmployeeID']);
Route::post('approveRequest',[MaintenanceController::class,'approveRequest']);
Route::post('report_maintenance_store',[MaintenanceController::class,'storeReport']);
Route::get('reportReqMaintainList/{reqMaintain}',[MaintenanceController::class,'getList']);
Route::post('testVal',[MaintenanceController::class,'test']);

//Building
Route::get('building', [BuildingController::class, 'getBuilding']);
Route::post('building_store', [BuildingController::class, 'storeBuilding']);
Route::get('floor', [BuildingController::class, 'getFloor']);
Route::post('floor_store', [BuildingController::class, 'storeFloor']);
Route::get('roomtype', [BuildingController::class, 'getRoomType']);
Route::get('room', [BuildingController::class, 'getRoom']);
Route::post('room_store', [BuildingController::class, 'storeRoom']);

//Employee
Route::get('employee', [EmployeeController::class, 'getEmployee']);

//RequestMaterial
Route::post('requestProductStore',[RequestMaterialController::class,'storeRequestProduct']);
Route::get('requestProductList',[RequestMaterialController::class,'getRequestMaterialList']);
Route::post('request_material_status',[RequestMaterialController::class,'changeStatus']);
Route::get('material_issue_list',[RequestMaterialController::class,'showIssueList']);

//Sale_Order
Route::get('sales_order',[SaleController::class,'getSaleOrders']);
Route::post('sales_order_save',[SaleController::class,'storeSaleOrder']);
Route::post('purchase/request',[SaleController::class,'purchaseRequest']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

