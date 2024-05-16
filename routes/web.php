<?php

use App\Http\Controllers\DonorsController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route to set locale to change lang
Route::get('/lang/{locale}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('lang.switch');

// main path for system
Route::get('/', function () {
    return redirect('/home');
})->middleware('auth');

Route::get('/home', function () {
    return view('index');
})->name('home');
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
// Route::get('/donors',[DonorsController::class,'index'])->name('donors.index');
// Route::get('/donor/add',[DonorsController::class,'addDonor'])->name('donors.add');

// Auth::routes();

// //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function () {
    // Route donors
    Route::group(['prefix' => 'donors', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'donors.index', 'uses' => 'App\Http\Controllers\DonorsController@index']);
        Route::get('/add', ['as' => 'donors.add', 'uses' => 'App\Http\Controllers\DonorsController@addDonor']);
        Route::post('/store', ['as' => 'donors.store', 'uses' => 'App\Http\Controllers\DonorsController@store']);
        Route::post('/update', ['as' => 'donors.update', 'uses' => 'App\Http\Controllers\DonorsController@update']);
        Route::get('/destroy', ['as' => 'donors.destroy', 'uses' => 'App\Http\Controllers\DonorsController@destroy']);
        Route::get('/donors', ['as' => 'donors.donors', 'uses' => 'App\Http\Controllers\DonorsController@donors']);
    });
    // end donors

    //Components Routes
    Route::group(['prefix' => 'components', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'compo.index', 'uses' => 'App\Http\Controllers\CompoController@index']);
        Route::post('/store', ['as' => 'compo.store', 'uses' => 'App\Http\Controllers\CompoController@store']);
        Route::post('/update', ['as' => 'compo.update', 'uses' => 'App\Http\Controllers\CompoController@update']);
        Route::get('/destroy', ['as' => 'compo.destroy', 'uses' => 'App\Http\Controllers\CompoController@destroy']);
    });

    //Sub Component Routes
    Route::group(['prefix' => '/component-sub', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'subCompo.index', 'uses' => 'App\Http\Controllers\SubCompoController@index']);
        Route::post('/store', ['as' => 'subCompo.store', 'uses' => 'App\Http\Controllers\SubCompoController@store']);
        Route::post('/update', ['as' => 'subCompo.update', 'uses' => 'App\Http\Controllers\SubCompoController@update']);
        Route::get('/destroy', ['as' => 'subCompo.destroy', 'uses' => 'App\Http\Controllers\SubCompoController@destroy']);
    });

    //Category Routes
    Route::group(['prefix' => 'categories', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'cate.index', 'uses' => 'App\Http\Controllers\CategoryController@index']);
        Route::post('/store', ['as' => 'cate.store', 'uses' => 'App\Http\Controllers\CategoryController@store']);
        Route::post('/update', ['as' => 'cate.update', 'uses' => 'App\Http\Controllers\CategoryController@update']);
        Route::get('/destroy', ['as' => 'cate.destroy', 'uses' => 'App\Http\Controllers\CategoryController@destroy']);
        Route::get('/categories', ['as' => 'cate.categories', 'uses' => 'App\Http\Controllers\CategoryController@categories']);
    });

    //BSPCategory Routes
    Route::group(['prefix' => 'BSP', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'bsp.index', 'uses' => 'App\Http\Controllers\BSPController@index']);
        Route::post('/store', ['as' => 'bsp.store', 'uses' => 'App\Http\Controllers\BSPController@store']);
        Route::post('/update', ['as' => 'bsp.update', 'uses' => 'App\Http\Controllers\BSPController@update']);
        Route::get('/destroy', ['as' => 'bsp.destroy', 'uses' => 'App\Http\Controllers\BSPController@destroy']);
    });

    //Account Type Routes
    Route::group(['prefix' => 'AccountType', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'acctType.index', 'uses' => 'App\Http\Controllers\AccountTypeController@index']);
        Route::post('/store', ['as' => 'acctType.store', 'uses' => 'App\Http\Controllers\AccountTypeController@store']);
        Route::post('/update', ['as' => 'acctType.update', 'uses' => 'App\Http\Controllers\AccountTypeController@update']);
        Route::get('/destroy', ['as' => 'acctType.destroy', 'uses' => 'App\Http\Controllers\AccountTypeController@destroy']);
    });

    //Account Group Routes
    Route::group(['prefix' => 'AccountGroup', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'acctGroup.index', 'uses' => 'App\Http\Controllers\AcctGroupController@index']);
        Route::post('/store', ['as' => 'acctGroup.store', 'uses' => 'App\Http\Controllers\AcctGroupController@store']);
        Route::post('/update', ['as' => 'acctGroup.update', 'uses' => 'App\Http\Controllers\AcctGroupController@update']);
        Route::get('/destroy', ['as' => 'acctGroup.destroy', 'uses' => 'App\Http\Controllers\AcctGroupController@destroy']);
    });

    //Account Routes
    Route::group(['prefix' => 'Account', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'account.index', 'uses' => 'App\Http\Controllers\AccountController@index']);
        Route::get('/account-api', ['as' => 'account.account-api', 'uses' => 'App\Http\Controllers\AccountController@getAllAccount']);
        Route::post('/store', ['as' => 'account.store', 'uses' => 'App\Http\Controllers\AccountController@store']);
        Route::post('/update', ['as' => 'account.update', 'uses' => 'App\Http\Controllers\AccountController@update']);
        Route::get('/destroy', ['as' => 'account.destroy', 'uses' => 'App\Http\Controllers\AccountController@destroy']);
    });

    //BankInfo Routes'
    Route::group(['prefix' => 'BankInfo', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'bankinfo.index', 'uses' => 'App\Http\Controllers\BankInfoController@index']);
        Route::post('/store', ['as' => 'bankinfo.store', 'uses' => 'App\Http\Controllers\BankInfoController@store']);
        Route::post('/update', ['as' => 'bankinfo.update', 'uses' => 'App\Http\Controllers\BankInfoController@update']);
        Route::get('/destroy', ['as' => 'bankinfo.destroy', 'uses' => 'App\Http\Controllers\BankInfoController@destroy']);
    });

    //BankNote Routes
    Route::group(['prefix' => 'BankNotes', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'bankNote.index', 'uses' => 'App\Http\Controllers\BankNoteController@index']);
        Route::post('/store', ['as' => 'bankNote.store', 'uses' => 'App\Http\Controllers\BankNoteController@store']);
        Route::post('/update', ['as' => 'bankNote.update', 'uses' => 'App\Http\Controllers\BankNoteController@update']);
        Route::get('/destroy', ['as' => 'bankNote.destroy', 'uses' => 'App\Http\Controllers\BankNoteController@destroy']);
    });

    //CostCenter Routes
    Route::group(['prefix' => 'CostCenter', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'costcenter.index', 'uses' => 'App\Http\Controllers\CostCenterController@index']);
        Route::post('/store', ['as' => 'costcenter.store', 'uses' => 'App\Http\Controllers\CostCenterController@store']);
        Route::post('/update', ['as' => 'costcenter.update', 'uses' => 'App\Http\Controllers\CostCenterController@update']);
        Route::get('/destroy', ['as' => 'costcenter.destroy', 'uses' => 'App\Http\Controllers\CostCenterController@destroy']);
        Route::get('/costCenters', ['as' => 'costcenter.costCenters', 'uses' => 'App\Http\Controllers\CostCenterController@costCenters']);
    });


    //Sub CostCenter Routes
    Route::group(['prefix' => 'SubCostCenter', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'sub.costcenter.index', 'uses' => 'App\Http\Controllers\SubCostCenterController@index']);
        Route::post('/store', ['as' => 'sub.costcenter.store', 'uses' => 'App\Http\Controllers\SubCostCenterController@store']);
        Route::post('/update', ['as' => 'sub.costcenter.update', 'uses' => 'App\Http\Controllers\SubCostCenterController@update']);
        Route::get('/destroy', ['as' => 'sub.costcenter.destroy', 'uses' => 'App\Http\Controllers\SubCostCenterController@destroy']);
        Route::get('/subCostCenters', ['as' => 'sub.costcenter.subCostCenters', 'uses' => 'App\Http\Controllers\SubCostCenterController@subCostCenters']);
    });

    //ActivityGroup Routes
    Route::group(['prefix' => 'ActivityType', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'activityGroup.index', 'uses' => 'App\Http\Controllers\ActivityGroupController@index']);
        Route::post('/store', ['as' => 'activityGroup.store', 'uses' => 'App\Http\Controllers\ActivityGroupController@store']);
        Route::post('/update', ['as' => 'activityGroup.update', 'uses' => 'App\Http\Controllers\ActivityGroupController@update']);
        Route::get('/destroy', ['as' => 'activityGroup.destroy', 'uses' => 'App\Http\Controllers\ActivityGroupController@destroy']);
    });

    //Activity Routes
    Route::group(['prefix' => 'Activity', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'activity.index', 'uses' => 'App\Http\Controllers\ActivityController@index']);
        Route::post('/store', ['as' => 'activity.store', 'uses' => 'App\Http\Controllers\ActivityController@store']);
        Route::post('/update', ['as' => 'activity.update', 'uses' => 'App\Http\Controllers\ActivityController@update']);
        Route::get('/destroy', ['as' => 'activity.destroy', 'uses' => 'App\Http\Controllers\ActivityController@destroy']);
        Route::get('/activities', ['as' => 'activity.activities', 'uses' => 'App\Http\Controllers\ActivityController@activities']);
    });

    //Office Routes
    Route::group(['prefix' => 'Office', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'office.index', 'uses' => 'App\Http\Controllers\OfficeController@index']);
        Route::post('/store', ['as' => 'office.store', 'uses' => 'App\Http\Controllers\OfficeController@store']);
        Route::post('/update', ['as' => 'office.update', 'uses' => 'App\Http\Controllers\OfficeController@update']);
        Route::get('/destroy', ['as' => 'office.destroy', 'uses' => 'App\Http\Controllers\OfficeController@destroy']);
    });

    //General Voucher Routes
    Route::group(['prefix' => 'GeneralVoucher', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'voucher.index', 'uses' => 'App\Http\Controllers\VoucherController@index']);
        Route::get('/add', ['as' => 'voucher.add', 'uses' => 'App\Http\Controllers\VoucherController@add']);
        Route::get('/update/{key}', ['as' => 'voucher.update', 'uses' => 'App\Http\Controllers\VoucherController@pageUpdate']);
        Route::get('/destroy', ['as' => 'voucher.destroy', 'uses' => 'App\Http\Controllers\VoucherController@destroy']);
        Route::get('/add/data/{key}', ['as' => 'voucher.add.info', 'uses' => 'App\Http\Controllers\VoucherController@fetchSingleData']);
        Route::get('/preview', ['as' => 'voucher.preview', 'uses' => 'App\Http\Controllers\VoucherController@preview']);
        Route::get('/preview/print', ['as' => 'voucher.print', 'uses' => 'App\Http\Controllers\VoucherController@print']);
        Route::get('/preview/data/{level}/{implementCD}/{voucherNo}', ['as' => 'voucher.preview.data', 'uses' => 'App\Http\Controllers\VoucherController@previewData']);
        Route::post('/store', ['as' => 'voucher.store', 'uses' => 'App\Http\Controllers\VoucherController@store']);
        Route::get('/accounts', ['as' => 'voucher.account', 'uses' => 'App\Http\Controllers\VoucherController@accounts']);
        Route::get('/provinces', ['as' => 'voucher.provinces', 'uses' => 'App\Http\Controllers\VoucherController@provinces']);
        Route::get('/districts', ['as' => 'voucher.districts', 'uses' => 'App\Http\Controllers\VoucherController@districts']);
        Route::get('/villages', ['as' => 'voucher.villages', 'uses' => 'App\Http\Controllers\VoucherController@villages']);
        Route::get('/levels', ['as' => 'voucher.level', 'uses' => 'App\Http\Controllers\VoucherController@levels']);
        Route::get('/vouchers', ['as' => 'voucher.vouchers', 'uses' => 'App\Http\Controllers\VoucherController@vouchers']);
    });
    //End General Voucher

    //Bank Voucher Routes
    Route::group(['prefix' => 'BankVoucher', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'bankVoucher.index', 'uses' => 'App\Http\Controllers\BankVoucherController@index']);
        Route::get('/add', ['as' => 'bankVoucher.add', 'uses' => 'App\Http\Controllers\BankVoucherController@add']);
        Route::put('/update', ['as' => 'bankVoucher.update', 'uses' => 'App\Http\Controllers\BankVoucherController@update']);
        Route::get('/details/preview/data', ['as' => 'bankVoucher.viewDetail', 'uses' => 'App\Http\Controllers\BankVoucherController@viewDetail']);
        Route::get('/destroy', ['as' => 'bankVoucher.destroy', 'uses' => 'App\Http\Controllers\BankVoucherController@destroy']);
        Route::get('/add/data/{key}', ['as' => 'bankVoucher.add.info', 'uses' => 'App\Http\Controllers\BankVoucherController@fetchSingleData']);
        Route::get('/preview', ['as' => 'bankVoucher.preview', 'uses' => 'App\Http\Controllers\BankVoucherController@preview']);
        Route::get('/preview/print', ['as' => 'bankVoucher.print', 'uses' => 'App\Http\Controllers\BankVoucherController@print']);
        Route::get('/preview/data/{level}/{implementCD}/{voucherNo}', ['as' => 'bankVoucher.preview.data', 'uses' => 'App\Http\Controllers\BankVoucherController@previewData']);
        Route::post('/store', ['as' => 'bankVoucher.store', 'uses' => 'App\Http\Controllers\BankVoucherController@store']);
        Route::get('/accounts', ['as' => 'bankVoucher.account', 'uses' => 'App\Http\Controllers\BankVoucherController@accounts']);
        Route::get('/provinces', ['as' => 'bankVoucher.provinces', 'uses' => 'App\Http\Controllers\BankVoucherController@provinces']);
        Route::get('/districts', ['as' => 'bankVoucher.districts', 'uses' => 'App\Http\Controllers\BankVoucherController@districts']);
        Route::get('/villages', ['as' => 'bankVoucher.villages', 'uses' => 'App\Http\Controllers\BankVoucherController@villages']);
        Route::get('/levels', ['as' => 'bankVoucher.level', 'uses' => 'App\Http\Controllers\BankVoucherController@levels']);
        Route::get('/vouchers', ['as' => 'bankVoucher.vouchers', 'uses' => 'App\Http\Controllers\BankVoucherController@vouchers']);
    });
    //End Bank Voucher

    //Cash Voucher Routes
    Route::group(['prefix' => 'CashVoucher', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'cashVoucher.index', 'uses' => 'App\Http\Controllers\CashVoucherController@index']);
        Route::get('/add', ['as' => 'cashVoucher.add', 'uses' => 'App\Http\Controllers\CashVoucherController@add']);
        Route::put('/update', ['as' => 'cashVoucher.update', 'uses' => 'App\Http\Controllers\CashVoucherController@update']);
        Route::get('/details/preview/data', ['as' => 'cashVoucher.viewDetail', 'uses' => 'App\Http\Controllers\CashVoucherController@viewDetail']);
        Route::get('/destroy', ['as' => 'cashVoucher.destroy', 'uses' => 'App\Http\Controllers\CashVoucherController@destroy']);
        Route::get('/add/data/{key}', ['as' => 'cashVoucher.add.info', 'uses' => 'App\Http\Controllers\CashVoucherController@fetchSingleData']);
        Route::get('/preview', ['as' => 'cashVoucher.preview', 'uses' => 'App\Http\Controllers\CashVoucherController@preview']);
        Route::get('/preview/print', ['as' => 'cashVoucher.print', 'uses' => 'App\Http\Controllers\CashVoucherController@print']);
        Route::get('/preview/data/{level}/{implementCD}/{voucherNo}', ['as' => 'cashVoucher.preview.data', 'uses' => 'App\Http\Controllers\CashVoucherController@previewData']);
        Route::post('/store', ['as' => 'cashVoucher.store', 'uses' => 'App\Http\Controllers\CashVoucherController@store']);
        Route::get('/accounts', ['as' => 'cashVoucher.account', 'uses' => 'App\Http\Controllers\CashVoucherController@accounts']);
        Route::get('/provinces', ['as' => 'cashVoucher.provinces', 'uses' => 'App\Http\Controllers\CashVoucherController@provinces']);
        Route::get('/districts', ['as' => 'cashVoucher.districts', 'uses' => 'App\Http\Controllers\CashVoucherController@districts']);
        Route::get('/villages', ['as' => 'cashVoucher.villages', 'uses' => 'App\Http\Controllers\CashVoucherController@villages']);
        Route::get('/levels', ['as' => 'cashVoucher.level', 'uses' => 'App\Http\Controllers\CashVoucherController@levels']);
        Route::get('/vouchers', ['as' => 'cashVoucher.vouchers', 'uses' => 'App\Http\Controllers\CashVoucherController@vouchers']);
    });
    //End Cash Voucher

    //TrailBalance
    Route::group(['prefix' => '/TrialBalance', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'trialBalance.index', 'uses' => 'App\Http\Controllers\TrailBalanceController@index']);
        Route::post('/clearData', ['as' => 'trialBalance.clearData', 'uses' => 'App\Http\Controllers\TrailBalanceController@setDataToTable']);
        Route::post('/preview', ['as' => 'trialBalance.preview', 'uses' => 'App\Http\Controllers\TrailBalanceController@preview']);
        Route::get('/accounts', ['as' => 'trialBalance.account', 'uses' => 'App\Http\Controllers\TrailBalanceController@accounts']);
        Route::get('/provinces', ['as' => 'trialBalance.provinces', 'uses' => 'App\Http\Controllers\TrailBalanceController@provinces']);
        Route::get('/districts', ['as' => 'trialBalance.districts', 'uses' => 'App\Http\Controllers\TrailBalanceController@districts']);
        Route::get('/villages', ['as' => 'trialBalance.villages', 'uses' => 'App\Http\Controllers\TrailBalanceController@villages']);
        Route::get('/levels', ['as' => 'trialBalance.level', 'uses' => 'App\Http\Controllers\TrailBalanceController@levels']);
        Route::get('/userInfo', ['as' => 'trialBalance.user', 'uses' => 'App\Http\Controllers\TrailBalanceController@userInfo']);
        Route::get('/signature', ['as' => 'trialBalance.sig', 'uses' => 'App\Http\Controllers\TrailBalanceController@signature']);
    });

    //Closing Balance Route
    Route::group(['prefix' => '/ClosingAccount', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'closing.index', 'uses' => 'App\Http\Controllers\ClosingAccountController@index']);
        Route::get('/provinces', ['as' => 'closing.provinces', 'uses' => 'App\Http\Controllers\ClosingAccountController@provinces']);
        Route::get('/districts', ['as' => 'closing.districts', 'uses' => 'App\Http\Controllers\ClosingAccountController@districts']);
        Route::get('/villages', ['as' => 'closing.villages', 'uses' => 'App\Http\Controllers\ClosingAccountController@villages']);
        Route::get('/levels', ['as' => 'closing.levels', 'uses' => 'App\Http\Controllers\ClosingAccountController@level']);
        Route::post('/closing', ['as' => 'closing.closing', 'uses' => 'App\Http\Controllers\ClosingAccountController@closingAccount']);
    });

    //OpenBalance
    Route::group(['prefix' => '/OpenBalance', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'open.index', 'uses' => 'App\Http\Controllers\OpenBalanceController@index']);
        Route::get('/provinces', ['as' => 'open.provinces', 'uses' => 'App\Http\Controllers\OpenBalanceController@provinces']);
        Route::get('/districts', ['as' => 'open.districts', 'uses' => 'App\Http\Controllers\OpenBalanceController@districts']);
        Route::get('/villages', ['as' => 'open.villages', 'uses' => 'App\Http\Controllers\OpenBalanceController@villages']);
        Route::get('/levels', ['as' => 'open.levels', 'uses' => 'App\Http\Controllers\OpenBalanceController@level']);
        Route::post('/list', ['as' => 'open.list', 'uses' => 'App\Http\Controllers\OpenBalanceController@loadData']);
        Route::post('/delete', ['as' => 'open.delete', 'uses' => 'App\Http\Controllers\OpenBalanceController@deleteOpenBalance']);
        Route::post('/preview', ['as' => 'open.preview', 'uses' => 'App\Http\Controllers\OpenBalanceController@preview']);
    });

    // Route province
    Route::group(['prefix' => 'province', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'province.index', 'uses' => 'App\Http\Controllers\provinceController@index']);
        Route::get('/destroy', ['as' => 'province.destroy', 'uses' => 'App\Http\Controllers\provinceController@destroy']);
        Route::post('/insert', ['as' => 'province.insert', 'uses' => 'App\Http\Controllers\provinceController@insert']);
        Route::get('/edit/{id}', ['as' => 'province.edit', 'uses' => 'App\Http\Controllers\provinceController@edit']);
        Route::post('/update', ['as' => 'province.update', 'uses' => 'App\Http\Controllers\provinceController@update']);
        Route::get('/destroy', ['as' => 'province.destroy', 'uses' => 'App\Http\Controllers\provinceController@destroy']);
        Route::get('/province-api', ['as' => 'province.getProvince', 'uses' => 'App\Http\Controllers\provinceController@getProvince']);
    });
    // end province

    // Route District
    Route::group(['prefix' => 'district', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'district.index', 'uses' => 'App\Http\Controllers\DistrictController@index']);
        Route::get('/district-api', ['as' => 'district.fetchGetDistrict', 'uses' => 'App\Http\Controllers\DistrictController@fetchGetDistrict']);
        Route::get('/destroy', ['as' => 'district.destroy', 'uses' => 'App\Http\Controllers\DistrictController@destroy']);
        Route::post('/store', ['as' => 'district.store', 'uses' => 'App\Http\Controllers\DistrictController@store']);
        Route::get('/edit/{id}', ['as' => 'district.edit', 'uses' => 'App\Http\Controllers\DistrictController@edit']);
        Route::post('/update', ['as' => 'district.update', 'uses' => 'App\Http\Controllers\DistrictController@update']);
    });

    // Route village
    Route::group(['prefix' => 'village', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'village.index', 'uses' => 'App\Http\Controllers\Villagecontroller@index']);
        Route::get('/destroy', ['as' => 'village.destroy', 'uses' => 'App\Http\Controllers\Villagecontroller@destroy']);
        Route::get('/village-api', ['as' => 'district.getVillageNew', 'uses' => 'App\Http\Controllers\Villagecontroller@getVillageNew']);
        Route::post('/store', ['as' => 'village.store', 'uses' => 'App\Http\Controllers\Villagecontroller@store']);
        Route::get('/edit/{id}', ['as' => 'village.edit', 'uses' => 'App\Http\Controllers\Villagecontroller@edit']);
        Route::get('/getvillage', ['as' => 'village.getvillage', 'uses' => 'App\Http\Controllers\Villagecontroller@getvillage']);
        Route::get('/actionLoad', ['as' => 'village.actionLoad', 'uses' => 'App\Http\Controllers\Villagecontroller@actionLoad']);
        Route::post('/update', ['as' => 'village.update', 'uses' => 'App\Http\Controllers\Villagecontroller@update']);
    });

    //General Voucher Advance Routes
    Route::group(['prefix' => 'VoucherAdvance', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'VoucherAdvance.index', 'uses' => 'App\Http\Controllers\VoucherAdvanceController@index']);
        Route::get('/addva', ['as' => 'VoucherAdvance.addva', 'uses' => 'App\Http\Controllers\VoucherAdvanceController@addva']);
        Route::get('/update/{key}', ['as' => 'VoucherAdvance.update', 'uses' => 'App\Http\Controllers\VoucherAdvanceController@pageUpdate']);
        Route::get('/add/data/{key}', ['as' => 'VoucherAdvance.add.info', 'uses' => 'App\Http\Controllers\VoucherAdvanceController@fetchSingleData']);
        Route::post('/store', ['as' => 'VoucherAdvance.store', 'uses' => 'App\Http\Controllers\VoucherAdvanceController@store']);
        Route::get('/destroy', ['as' => 'VoucherAdvance.destroy', 'uses' => 'App\Http\Controllers\VoucherAdvanceController@destroy']);
        Route::get('/preview', ['as' => 'VoucherAdvance.preview', 'uses' => 'App\Http\Controllers\VoucherAdvanceController@preview']);
        Route::get('/preview/data/{level}/{implementCD}/{voucherNo}', ['as' => 'VoucherAdvance.preview.data', 'uses' => 'App\Http\Controllers\VoucherAdvanceController@previewData']);
        Route::get('/voucher-json', ['as' => 'VoucherAdvance.json.data', 'uses' => 'App\Http\Controllers\VoucherAdvanceController@getAdvanceVoucherJson']);
    });

    //Voucher Advance Clear Routes
    Route::group(['prefix' => 'VoucherAdvanceClear', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'VoucherAdvanceClear.index', 'uses' => 'App\Http\Controllers\VoucherAdvanceClearController@index']);
        Route::get('/addva', ['as' => 'VoucherAdvanceClear.addva', 'uses' => 'App\Http\Controllers\VoucherAdvanceClearController@addva']);
        Route::get('/update/{key}', ['as' => 'VoucherAdvanceClear.update', 'uses' => 'App\Http\Controllers\VoucherAdvanceController@pageUpdate']);
        Route::get('/accounts', ['as' => 'VoucherAdvanceClear.account', 'uses' => 'App\Http\Controllers\VoucherAdvanceClearController@accounts']);
        Route::get('/currencies', ['as' => 'VoucherAdvanceClear.currencies', 'uses' => 'App\Http\Controllers\VoucherAdvanceClearController@currencies']);
        Route::get('/provinces', ['as' => 'VoucherAdvanceClear.provinces', 'uses' => 'App\Http\Controllers\VoucherAdvanceClearController@provinces']);
        Route::get('/districts', ['as' => 'VoucherAdvanceClear.districts', 'uses' => 'App\Http\Controllers\VoucherAdvanceClearController@districts']);
        Route::get('/villages', ['as' => 'VoucherAdvanceClear.villages', 'uses' => 'App\Http\Controllers\VoucherAdvanceClearController@villages']);
        Route::get('/preview/data/{level}/{implementCD}/{voucherNo}', ['as' => 'VoucherAdvanceClear.preview.data', 'uses' => 'App\Http\Controllers\VoucherAdvanceClearController@previewData']);
    });

    //Reports Routes
    Route::group(['prefix' => '/Reports', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'report.index', 'uses' => 'App\Http\Controllers\ReportController@index']);

        Route::post('/transaction-gl-report', ['as' => 'transaction-gl.index', 'uses' => 'App\Http\Controllers\TransactionGLController@index']);
        Route::post('/transaction-gl-report/preview', ['as' => 'transaction-gl.report', 'uses' => 'App\Http\Controllers\TransactionGLController@report']);
        Route::post('/journalReport', ['as' => 'report.journal', 'uses' => 'App\Http\Controllers\ReportController@generalJournal']);
        // Route::group(['prefix' => '/Reports', 'middleware' => ['auth']], function () {
        Route::post('/ledgerReport', ['as' => 'report.ledger', 'uses' => 'App\Http\Controllers\ReportController@generalLedger']);


        Route::get('/quarter', ['as' => 'report.quarter', 'uses' => 'App\Http\Controllers\QuarterReportController@index']);
        Route::get('/quarter/provinces', ['as' => 'quarter.province', 'uses' => 'App\Http\Controllers\QuarterReportController@provinces']);
        Route::get('/quarter/district', ['as' => 'quarter.district', 'uses' => 'App\Http\Controllers\QuarterReportController@district']);
        Route::get('/quarter/village', ['as' => 'quarter.village', 'uses' => 'App\Http\Controllers\QuarterReportController@village']);
        Route::get('/quarter/levels', ['as' => 'quarter.level', 'uses' => 'App\Http\Controllers\QuarterReportController@level']);
        //Route::get('/quarter/levels',['as'=>'quarter.level','uses'=>'App\Http\Controllers\QuarterReportController@level']);

        // Pad Budget
        Route::get('/pad-budget', ['as' => 'pad-budget.index', 'uses' => 'App\Http\Controllers\PadBudgetController@index']);
        Route::post('/pad-budget/data', ['as' => 'pad-budget.data', 'uses' => 'App\Http\Controllers\PadBudgetController@loadPadBudgetData']);
        Route::post('/pad-budget/save', ['as' => 'pad-budget.save', 'uses' => 'App\Http\Controllers\PadBudgetController@savePadBudget']);
        Route::post('/pad-budget/preview', ['as' => 'pad-budget.preview', 'uses' => 'App\Http\Controllers\PadBudgetController@preViewPadBudgetData']);

        Route::get('/', ['as' => 'report.index', 'uses' => 'App\Http\Controllers\ReportController@index']);
        Route::post('/journalReport', ['as' => 'report.journal', 'uses' => 'App\Http\Controllers\ReportController@generalJournal']);
        Route::post('/ledgerReport', ['as' => 'report.ledger', 'uses' => 'App\Http\Controllers\ReportController@generalLedger']);
        Route::get('/quarter', ['as' => 'report.quarter', 'uses' => 'App\Http\Controllers\QuarterReportController@index']);
        Route::get('/quarter/provinces', ['as' => 'quarter.province', 'uses' => 'App\Http\Controllers\QuarterReportController@provinces']);
        Route::get('/quarter/district', ['as' => 'quarter.district', 'uses' => 'App\Http\Controllers\QuarterReportController@district']);
        Route::get('/quarter/village', ['as' => 'quarter.village', 'uses' => 'App\Http\Controllers\QuarterReportController@village']);
        Route::get('/quarter/levels', ['as' => 'quarter.level', 'uses' => 'App\Http\Controllers\QuarterReportController@level']);
        Route::get('/quarter/levels', ['as' => 'quarter.level', 'uses' => 'App\Http\Controllers\QuarterReportController@level']);
        Route::post('/quarter/showData', ['as' => 'report.quarter.data', 'uses' => 'App\Http\Controllers\QuarterReportController@loadDataToShow']);
        Route::post('/quarter/preview', ['as' => 'report.quarter.preview', 'uses' => 'App\Http\Controllers\QuarterReportController@previewReports']);
        Route::post('/quarter/update/data', ['as' => 'report.quarter.update', 'uses' => 'App\Http\Controllers\QuarterReportController@callStoredProcedure']);


        // Project Report
        Route::get('/bank-control-book-report', ['as' => 'report.bank-control-book-report', 'uses' => 'App\Http\Controllers\BankControlBookReport@index']);
        Route::get('/bank-control-book-report/account', ['as' => 'report.bank-control-book-report.account', 'uses' => 'App\Http\Controllers\BankControlBookReport@accounts']);
        Route::get('/bank-control-book-report/signature/{code}', ['as' => 'report.bank-control-book-report.signature', 'uses' => 'App\Http\Controllers\BankControlBookReport@signature']);
        Route::post('/bank-control-book-report/gen-report', ['as' => 'report.bank-control-book-report.gen-report', 'uses' => 'App\Http\Controllers\BankControlBookReport@genarateQuery']);
        Route::get('/bank-control-book-report/preview/{code}', ['as' => 'report.bank-control-book-report.preview', 'uses' => 'App\Http\Controllers\BankControlBookReport@preview']);
    });

    Route::group(['prefix' => '/users', 'middleware' => ['auth']], function () {
        Route::get('/index', ['as' => 'users.index', 'uses' => 'App\Http\Controllers\UserController@index']);
        Route::get('/fetch', ['as' => 'users.fetch', 'uses' => 'App\Http\Controllers\UserController@getAllUser']);
        Route::get('/level', ['as' => 'users.level', 'uses' => 'App\Http\Controllers\UserController@getAllLevels']);
        Route::get('/permission/{userId}', ['as' => 'users.permission-user', 'uses' => 'App\Http\Controllers\UserController@getPermissionMenuByUser']);
        Route::get('/my-account', ['as' => 'users.my-account', 'uses' => 'App\Http\Controllers\UserController@my_account_page']);
        Route::post('/create', ['as' => 'users.create', 'uses' => 'App\Http\Controllers\UserController@createUser']);
        Route::get('/menu/{menuId}', ['as' => 'users.create', 'uses' => 'App\Http\Controllers\UserController@findMenuByMenuId']);
        Route::post('/permit-menu', ['as' => 'users.permit-menu', 'uses' => 'App\Http\Controllers\UserController@permissionMenuToUser']);
        Route::put('/change-password', ['as' => 'users.change-password', 'uses' => 'App\Http\Controllers\UserController@change_password']);
        Route::delete('/delete/{userId}', ['as' => 'users.delete', 'uses' => 'App\Http\Controllers\UserController@destroy']);
        Route::put('/update/{userId}', ['as' => 'users.update', 'uses' => 'App\Http\Controllers\UserController@updateUser']);
    });

    Route::group(['prefix' => '/currency', 'middleware' => ['auth']], function () {
        Route::get('/currency-api', ['as' => 'currency.getCurrency', 'uses' => 'App\Http\Controllers\CurrencyController@getCurrency']);
    });

    Route::group(['prefix' => '/levels', 'middleware' => ['auth']], function () {
        Route::get('/level-api', ['as' => 'level.getLevel', 'uses' => 'App\Http\Controllers\LevelController@getLevel']);
    });

    Route::group(['prefix' => 'middle-voucher', 'middleware' => ['auth']], function () {
        Route::get('/all', ['as' => 'middle-voucher.all', 'uses' => 'App\Http\Controllers\MiddleVoucherController@getAll']);
        Route::post('/store', ['as' => 'middle-voucher.store', 'uses' => 'App\Http\Controllers\MiddleVoucherController@store']);
        Route::put('/update/single/{voucherId}', ['as' => 'middle-voucher.update', 'uses' => 'App\Http\Controllers\MiddleVoucherController@updateVoucherData']);
        Route::delete('/delete/{voucherId}', ['as' => 'middle-voucher.delete', 'uses' => 'App\Http\Controllers\MiddleVoucherController@destroyVoucher']);

        // item
        Route::delete('/delete/item/{rec_cnt}', ['as' => 'middle-voucher.delete-item', 'uses' => 'App\Http\Controllers\MiddleVoucherController@destroyVoucherItem']);
    });

    Route::group(['prefix' => 'print', 'middleware' => ['auth']], function () {
        Route::get('/deposit-book', ['as' => 'print.showVoucherDepositBook', 'uses' => 'App\Http\Controllers\PrintReportController@pagePrintVoucherDepositBook']);
        Route::get('/deposit-book/data', ['as' => 'print.dataVoucherDepositBook', 'uses' => 'App\Http\Controllers\PrintReportController@dataPrintVoucherDepositBook']);

        Route::get('/cash-book', ['as' => 'print.showVoucherCashBook', 'uses' => 'App\Http\Controllers\PrintReportController@pagePrintVoucherCashBook']);
        Route::get('/cash-book/data', ['as' => 'print.dataVoucherCashBook', 'uses' => 'App\Http\Controllers\PrintReportController@dataPrintVoucherCashBook']);

        Route::get('/voucher-advance-tracking-book', ['as' => 'print.showVouchervoucherAdvanceTrackingBook', 'uses' => 'App\Http\Controllers\PrintReportController@pagePrintVouchervoucherAdvanceTrackingBook']);
        Route::get('/voucher-advance-tracking-book/data', ['as' => 'print.dataVouchervoucherAdvanceTrackingBook', 'uses' => 'App\Http\Controllers\PrintReportController@dataPrintVouchervoucherAdvanceTrackingBook']);

        Route::get('/voucher-transaction', ['as' => 'print.showVoucherTransaction', 'uses' => 'App\Http\Controllers\PrintReportController@pagePrintVoucherTransaction']);
        Route::post('/voucher-transaction/data', ['as' => 'print.dataVoucherTransaction', 'uses' => 'App\Http\Controllers\PrintReportController@dataPrintVoucherTransaction']);

        Route::get('/voucher-general', ['as' => 'print.showVoucherGeneral', 'uses' => 'App\Http\Controllers\PrintReportController@pagePrintVoucherGeneral']);
        Route::get('/voucher-general/data', ['as' => 'print.dataVoucherGeneral', 'uses' => 'App\Http\Controllers\PrintReportController@dataPrintVoucherGeneral']);

        Route::get('/separate-account-book', ['as' => 'print.showSeparateAccountBook', 'uses' => 'App\Http\Controllers\PrintReportController@pagePrintSeparateAccountBook']);
        Route::get('/separate-account-book/data', ['as' => 'print.dataSeparateAccountBook', 'uses' => 'App\Http\Controllers\PrintReportController@dataPrintSeparateAccountBook']);

        Route::get('/account-balance', ['as' => 'print.showAccountBalance', 'uses' => 'App\Http\Controllers\PrintReportController@pagePrintAccountBalance']);
        Route::get('/account-balance/data', ['as' => 'print.dataAccountBalance', 'uses' => 'App\Http\Controllers\PrintReportController@dataPrintAccountBalance']);

        Route::get('/trial-balance', ['as' => 'print.showTrialBalance', 'uses' => 'App\Http\Controllers\PrintReportController@pagePrintTrialBalance']);
        Route::post('/trial-balance/data', ['as' => 'print.dataTrialBalance', 'uses' => 'App\Http\Controllers\PrintReportController@dataPrintTrialBalance']);

        Route::get('/voucher-transaction-daily', ['as' => 'print.showVoucherTransactionDaily', 'uses' => 'App\Http\Controllers\PrintReportController@pagePrintVoucherTransactionDaily']);
        Route::post('/voucher-transaction-daily/data', ['as' => 'print.dataVoucherTransactionDaily', 'uses' => 'App\Http\Controllers\PrintReportController@dataPrintVoucherTransactionDaily']);

        Route::get('/voucher-ledger', ['as' => 'print.showVoucherLedger', 'uses' => 'App\Http\Controllers\PrintReportController@pagePrintVoucherLedger']);
        Route::post('/voucher-ledger/data', ['as' => 'print.dataVoucherLedger', 'uses' => 'App\Http\Controllers\PrintReportController@dataPrintVoucherLedger']);
    });

    // BankReconcileController
    Route::group(['prefix' => 'bank-reconcile', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'bank-reconcile.index', 'uses' => 'App\Http\Controllers\BankReconcileController@index']);
        Route::get('/new', ['as' => 'bank-reconcile.createPage', 'uses' => 'App\Http\Controllers\BankReconcileController@createPage']);
    });

    Route::group(['prefix' => '/cash-reconcile', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'cash.rc', 'uses' => 'App\Http\Controllers\CashReconcileController@index']);
        Route::get('/NewCashReconcile', ['as' => 'cash.rc.new', 'uses' => 'App\Http\Controllers\CashReconcileController@newCashReconcile']);
        
        Route::get('/bankNotes', ['cash.bankNote', 'uses' => 'App\Http\Controllers\CashReconcileController@loadBankNotes']);
        Route::get('/reconcile', ['cash.reconcile', 'uses' => 'App\Http\Controllers\CashReconcileController@loadReconcile']);
        Route::post('/reconcile/preview', ['cash.recon.preview', 'uses' => 'App\Http\Controllers\CashReconcileController@cashReconcilePreview']);
        Route::get('/reconcileItem/{id}/{level}/{implement}', ['cash.reconcileItem', 'uses' => 'App\Http\Controllers\CashReconcileController@loadReconcileItem']);
        Route::get('/reconcile/delete/{voucher}/{level}/{implement}', ['cash.recon.del', 'uses' => 'App\Http\Controllers\CashReconcileController@cashReconDelete']);
        Route::get('/levels', ['cash.recon.level', 'uses' => 'App\Http\Controllers\CashReconcileController@level']);
        Route::get('/accounts', ['cash.recon.account', 'uses' => 'App\Http\Controllers\CashReconcileController@accounts']);
        Route::post('/calculate', ['cash.recon.cal', 'uses' => 'App\Http\Controllers\CashReconcileController@calculate']);
        Route::post('/storeNewReconcile', ['cash.recon.store', 'uses' => 'App\Http\Controllers\CashReconcileController@storeData']);
    });
});
