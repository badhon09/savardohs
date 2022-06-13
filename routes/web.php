<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\LanguageController;

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

Route::get('prnt', [StaterkitController::class, 'prnt'])->name('prnt');

Route::middleware(['auth:sanctum', 'verified', 'RevenueID'])->group(function(){

    Route::get('/', [StaterkitController::class, 'home']);
    Route::get('home', [StaterkitController::class, 'home'])->name('home');
    // Route Components
    Route::get('layouts/collapsed-menu', [StaterkitController::class, 'collapsed_menu'])->name('collapsed-menu');
    Route::get('layouts/full', [StaterkitController::class, 'layout_full'])->name('layout-full');
    Route::get('layouts/without-menu', [StaterkitController::class, 'without_menu'])->name('without-menu');
    Route::get('layouts/empty', [StaterkitController::class, 'layout_empty'])->name('layout-empty');
    Route::get('layouts/blank', [StaterkitController::class, 'layout_blank'])->name('layout-blank');


    // locale Route
    Route::get('lang/{locale}', [LanguageController::class, 'swap']);


    /// for Store Mapping
    Route::get('shop/mapping/mapping-list', [\App\Http\Controllers\Shop\Mapping\ShopMappingController::class, 'index'])->name('shop/mapping/mapping-list');
    Route::get('shop/mapping/mapping-create', [\App\Http\Controllers\Shop\Mapping\ShopMappingController::class, 'create'])->name('shop/mapping/mapping-list');
    Route::post('shop/mapping/mapping-store', [\App\Http\Controllers\Shop\Mapping\ShopMappingController::class, 'store'])->name('shop/mapping/mapping-list');

    Route::get('bill-generate/month-wise-bill-list', [App\Http\Controllers\Shop\BillGenerate\MonthWiseBillController::class, 'index'])->name('bill-generate/month-wise-bill-list');
    Route::get('bill-generate/month-wise-bill-create', [App\Http\Controllers\Shop\BillGenerate\MonthWiseBillController::class, 'create'])->name('bill-generate/month-wise-bill-list');
    Route::post('bill-generate/month-wise-bill-create', [App\Http\Controllers\Shop\BillGenerate\MonthWiseBillController::class, 'GenerateBill'])->name('bill-generate/month-wise-bill-list');
    Route::post('bill-generate/month-wise-bill-store', [App\Http\Controllers\Shop\BillGenerate\MonthWiseBillController::class, 'store'])->name('bill-generate/month-wise-bill-list');

    /// MonthWise Meter Reading
    Route::get('meter-reading/meter-reading-list', [\App\Http\Controllers\MeterReding\MeterReadingController::class,'index'])->name('meter-reading/meter-reading-list');
    Route::get('meter-reading/meter-reading-create', [\App\Http\Controllers\MeterReding\MeterReadingController::class, 'create'])->name('meter-reading/meter-reading-list');
    Route::get('meter-reading/meter-reading-publish', [\App\Http\Controllers\MeterReding\MeterReadingController::class, 'publish'])->name('meter-reading/meter-reading-publish');
    Route::get('meter-reading/meter-reading-publish-common-area', [\App\Http\Controllers\MeterReding\MeterReadingController::class, 'publishCommonArea'])->name('meter-reading/meter-reading-publish-common-area');

    /// new controller
    Route::get('meter-reading/meter-reading-update', [\App\Http\Controllers\MeterReadingUpdateController::class, 'index'])->name('meter-reading/meter-reading-update');
    Route::post('meter-reading/meter-reading-update', [\App\Http\Controllers\MeterReadingUpdateController::class, 'StoreData'])->name('meter-reading/meter-reading-update');

    /// for institute info
    Route::get('institute/institute-list', [\App\Http\Controllers\Institute\InstituteController::class, 'index'])->name('institute/institute-list');
    Route::get('institute/institute-create', [\App\Http\Controllers\Institute\InstituteController::class, 'create'])->name('institute/institute-list');
    Route::post('institute/institute-store', [\App\Http\Controllers\Institute\InstituteController::class, 'store'])->name('institute/institute-list');
    Route::get('institute/institute-edit/{id}', [\App\Http\Controllers\Institute\InstituteController::class, 'edit'])->name('institute/institute-list');
    Route::get('institute/institute-delete/{id}', [\App\Http\Controllers\Institute\InstituteController::class, 'delete'])->name('institute/institute-list');

    /// for shop info
    // Route::get('shop-info/shop-info-list', [\App\Http\Controllers\ShopInfo\ShopInfoController::class, 'index'])->name('shop-info/shop-info-list');
    Route::get('flat-info/flat-info-create', [\App\Http\Controllers\StaterkitController::class, 'create'])->name('shop-info/shop-info-list');
    // Route::post('shop-info/shop-info-store', [\App\Http\Controllers\ShopInfo\ShopInfoController::class, 'store'])->name('shop-info/shop-info-list');
    // Route::get('shop-info/shop-info-edit/{id}', [\App\Http\Controllers\ShopInfo\ShopInfoController::class, 'edit'])->name('shop-info/shop-info-list');
    // Route::get('shop-info/shop-info-delete/{id}', [\App\Http\Controllers\ShopInfo\ShopInfoController::class, 'delete'])->name('shop-info/shop-info-list');

    /// for shop rate info
    Route::get('shop-rate-info/shop-rate-info-list', [\App\Http\Controllers\ShopRateInfo\ShopRateInfoController::class, 'index'])->name('shop-rate-info/shop-rate-info-list');
    Route::get('shop-rate-info/shop-rate-info-create', [\App\Http\Controllers\ShopRateInfo\ShopRateInfoController::class, 'create'])->name('shop-rate-info/shop-rate-info-list');
    Route::post('shop-rate-info/shop-rate-info-store', [\App\Http\Controllers\ShopRateInfo\ShopRateInfoController::class, 'store'])->name('shop-rate-info/shop-rate-info-list');
    Route::get('shop-rate-info/shop-rate-info-edit/{id}', [\App\Http\Controllers\ShopRateInfo\ShopRateInfoController::class, 'edit'])->name('shop-rate-info/shop-rate-info-list');
    Route::get('shop-rate-info/shop-rate-info-delete/{id}', [\App\Http\Controllers\ShopRateInfo\ShopRateInfoController::class, 'delete'])->name('shop-rate-info/shop-rate-info-list');

    /// for shop type
    Route::get('shop-type/shop-type-list', [\App\Http\Controllers\ShopType\ShopTypeController::class, 'index'])->name('shop-type/shop-type-list');
    Route::get('shop-type/shop-type-create', [\App\Http\Controllers\ShopType\ShopTypeController::class, 'create'])->name('shop-type/shop-type-list');
    Route::post('shop-type/shop-type-store', [\App\Http\Controllers\ShopType\ShopTypeController::class, 'store'])->name('shop-type/shop-type-list');
    Route::get('shop-type/shop-type-edit/{id}', [\App\Http\Controllers\ShopType\ShopTypeController::class, 'edit'])->name('shop-type/shop-type-list');
    Route::get('shop-type/shop-type-delete/{id}', [\App\Http\Controllers\ShopType\ShopTypeController::class, 'delete'])->name('shop-type/shop-type-list');

    /// for revenue
    Route::get('revenue/revenue-list', [\App\Http\Controllers\Revenue\RevenueController::class, 'index'])->name('revenue/revenue-list');
    Route::get('revenue/revenue-create', [\App\Http\Controllers\Revenue\RevenueController::class, 'create'])->name('revenue/revenue-list');
    Route::post('revenue/revenue-store', [\App\Http\Controllers\Revenue\RevenueController::class, 'store'])->name('revenue/revenue-list');
    Route::get('revenue/revenue-edit/{id}', [\App\Http\Controllers\Revenue\RevenueController::class, 'edit'])->name('revenue/revenue-list');
    Route::get('revenue/revenue-delete/{id}', [\App\Http\Controllers\Revenue\RevenueController::class, 'delete'])->name('revenue/revenue-list');

    /// for revenue-head
    Route::get('revenue-head/revenue-head-list', [\App\Http\Controllers\RevenueHead\RevenueHeadController::class, 'index'])->name('revenue-head/revenue-head-list');
    Route::get('revenue-head/revenue-head-create', [\App\Http\Controllers\RevenueHead\RevenueHeadController::class, 'create'])->name('revenue-head/revenue-head-list');
    Route::post('revenue-head/revenue-head-store', [\App\Http\Controllers\RevenueHead\RevenueHeadController::class, 'store'])->name('revenue-head/revenue-head-list');
    Route::get('revenue-head/revenue-head-edit/{id}', [\App\Http\Controllers\RevenueHead\RevenueHeadController::class, 'edit'])->name('revenue-head/revenue-head-list');
    Route::get('revenue-head/revenue-head-delete/{id}', [\App\Http\Controllers\RevenueHead\RevenueHeadController::class, 'delete'])->name('revenue-head/revenue-head-list');

    /// for user admin
    Route::get('admin-user/admin-user-create', [\App\Http\Controllers\AdminUser\AdminUserController::class, 'create'])->name('admin-user/admin-user-list');
    Route::get('admin-user/admin-user-list', [\App\Http\Controllers\AdminUser\AdminUserController::class, 'index'])->name('admin-user/admin-user-list');
    Route::get('admin-user/admin-user-edit/{id}', [\App\Http\Controllers\AdminUser\AdminUserController::class, 'edit'])->name('admin-user/admin-user-list');

    /// for user billing
    Route::get('billing/billing-create', [\App\Http\Controllers\Billing\BillingController::class, 'create'])->name('billing/billing-list');
    Route::get('billing/billing-list', [\App\Http\Controllers\Billing\BillingController::class, 'index'])->name('billing/billing-list');
    Route::get('billing/billing-edit/{id}', [\App\Http\Controllers\Billing\BillingController::class, 'edit'])->name('billing/billing-list');

    /// for user settlement
    Route::get('settlement/settlement-create', [\App\Http\Controllers\Settlement\SettlementController::class, 'create'])->name('settlement/settlement-list');
    Route::get('settlement/settlement-list', [\App\Http\Controllers\Settlement\SettlementController::class, 'index'])->name('settlement/settlement-list');
    Route::get('settlement/settlement-edit/{id}', [\App\Http\Controllers\Settlement\SettlementController::class, 'edit'])->name('settlement/settlement-list');


    /// for report
    Route::get('report/user-payment', [\App\Http\Controllers\Report\ReportController::class, 'user'])->name('report/report-list');
    Route::get('report/user-payment-pdf/{id}', [\App\Http\Controllers\Report\ReportController::class, 'userPdf'])->name('report/report-list');
    Route::get('report/online-settlement', [\App\Http\Controllers\Report\ReportController::class, 'settlement'])->name('report/report-list');
    Route::get('report/payment-realization', [\App\Http\Controllers\Report\ReportController::class, 'realization'])->name('report/report-list');
    Route::get('report/pdf-online-settlement', [\App\Http\Controllers\Report\ReportController::class, 'pdf_settlement'])->name('report/report-list');
    Route::get('report/pdf-payment-realization', [\App\Http\Controllers\Report\ReportController::class, 'pdf_realization'])->name('report/report-list');

    /// for user otp
    Route::get('otp/otp-create', [\App\Http\Controllers\Otp\OtpController::class, 'create'])->name('otp/otp-list');
    Route::get('otp/otp-list', [\App\Http\Controllers\Otp\OtpController::class, 'index'])->name('otp/otp-list');
    // Route::get('otp/payslip/{id}', [\App\Http\Controllers\Otp\OtpController::class, 'edit'])->name('otp/otp-list');
    // Route::get('otp/payslip/{id}', [\App\Http\Controllers\Otp\OtpController::class, 'edit'])->name('otp/otp-list');

    /// for user info
    Route::get('user-info/user-info-list', [\App\Http\Controllers\UserInfo\UserInfoController::class, 'index'])->name('user-info/user-info-list');
    Route::get('user-info/user-info-create', [\App\Http\Controllers\UserInfo\UserInfoController::class, 'create'])->name('user-info/user-info-list');
    Route::post('user-info/user-info-store', [\App\Http\Controllers\UserInfo\UserInfoController::class, 'store'])->name('user-info/user-info-list');
    Route::get('user-info/user-info-edit/{id}', [\App\Http\Controllers\UserInfo\UserInfoController::class, 'edit'])->name('user-info/user-info-list');
    Route::get('user-info/user-info-delete/{id}', [\App\Http\Controllers\UserInfo\UserInfoController::class, 'delete'])->name('user-info/user-info-list');

    /// for user type
    Route::get('user-type/user-type-list', [\App\Http\Controllers\UserType\UserTypeController::class, 'index'])->name('user-type/user-type-list');
    Route::get('user-type/user-type-create', [\App\Http\Controllers\UserType\UserTypeController::class, 'create'])->name('user-type/user-type-list');
    Route::post('user-type/user-type-store', [\App\Http\Controllers\UserType\UserTypeController::class, 'store'])->name('user-type/user-type-list');
    Route::get('user-type/user-type-edit/{id}', [\App\Http\Controllers\UserType\UserTypeController::class, 'edit'])->name('user-type/user-type-list');
    Route::get('user-type/user-type-delete/{id}', [\App\Http\Controllers\UserType\UserTypeController::class, 'delete'])->name('user-type/user-type-list');

    /// payment master
    Route::get('payment-master/payment-master-list', [\App\Http\Controllers\PaymentMaster\PaymentMasterController::class, 'index'])->name('payment-master/payment-master-list');
    Route::get('payment-master/payment-master-create', [\App\Http\Controllers\PaymentMaster\PaymentMasterController::class, 'create'])->name('payment-master/payment-master-list');
    Route::post('payment-master/payment-master-store', [\App\Http\Controllers\PaymentMaster\PaymentMasterController::class, 'store'])->name('payment-master/payment-master-list');
    Route::get('payment-master/payment-master-edit/{id}', [\App\Http\Controllers\PaymentMaster\PaymentMasterController::class, 'edit'])->name('payment-master/payment-master-list');
    Route::get('payment-master/payment-master-delete/{id}', [\App\Http\Controllers\PaymentMaster\PaymentMasterController::class, 'delete'])->name('payment-master/payment-master-list');

    /// payment child
    Route::get('payment-child/payment-child-list', [\App\Http\Controllers\PaymentChild\PaymentChildController::class, 'index'])->name('payment-child/payment-child-list');
    Route::get('payment-child/payment-child-create', [\App\Http\Controllers\PaymentChild\PaymentChildController::class, 'create'])->name('payment-child/payment-child-list');
    Route::post('payment-child/payment-child-store', [\App\Http\Controllers\PaymentChild\PaymentChildController::class, 'store'])->name('payment-child/payment-child-list');
    Route::get('payment-child/payment-child-edit/{id}', [\App\Http\Controllers\PaymentChild\PaymentChildController::class, 'edit'])->name('payment-child/payment-child-list');
    Route::get('payment-child/payment-child-delete/{id}', [\App\Http\Controllers\PaymentChild\PaymentChildController::class, 'delete'])->name('payment-child/payment-child-list');

    /// bill master
    Route::get('bill-master/bill-master-list', [\App\Http\Controllers\BillMaster\BillMasterController::class, 'index'])->name('bill-master/bill-master-list');
    Route::get('bill-master/bill-master-create', [\App\Http\Controllers\BillMaster\BillMasterController::class, 'create'])->name('bill-master/bill-master-list');
    Route::post('bill-master/bill-master-store', [\App\Http\Controllers\BillMaster\BillMasterController::class, 'store'])->name('bill-master/bill-master-list');
    Route::get('bill-master/bill-master-edit/{id}', [\App\Http\Controllers\BillMaster\BillMasterController::class, 'edit'])->name('bill-master/bill-master-list');
    Route::get('bill-master/bill-master-delete/{id}', [\App\Http\Controllers\BillMaster\BillMasterController::class, 'delete'])->name('bill-master/bill-master-list');

    /// bill child
    Route::get('bill-child/bill-child-list', [\App\Http\Controllers\BillChild\BillChildController::class, 'index'])->name('bill-child/bill-child-list');
    Route::get('bill-child/bill-child-create', [\App\Http\Controllers\BillChild\BillChildController::class, 'create'])->name('bill-child/bill-child-list');
    Route::post('bill-child/bill-child-store', [\App\Http\Controllers\BillChild\BillChildController::class, 'store'])->name('bill-child/bill-child-list');
    Route::get('bill-child/bill-child-edit/{id}', [\App\Http\Controllers\BillChild\BillChildController::class, 'edit'])->name('bill-child/bill-child-list');
    Route::get('bill-child/bill-child-delete/{id}', [\App\Http\Controllers\BillChild\BillChildController::class, 'delete'])->name('bill-child/bill-child-list');

    /// bill child
    Route::get('bill-month-info/bill-month-info-list', [\App\Http\Controllers\BillMonthInfo\BillMonthController::class, 'index'])->name('bill-month-info/bill-month-info-list');
    Route::get('bill-month-info/bill-month-info-create', [\App\Http\Controllers\BillMonthInfo\BillMonthController::class, 'create'])->name('bill-month-info/bill-month-info-list');
    Route::post('bill-month-info/bill-month-info-store', [\App\Http\Controllers\BillMonthInfo\BillMonthController::class, 'store'])->name('bill-month-info/bill-month-info-list');
    Route::get('bill-month-info/bill-month-info-edit/{id}', [\App\Http\Controllers\BillMonthInfo\BillMonthController::class, 'edit'])->name('bill-month-info/bill-month-info-list');
    Route::get('bill-month-info/bill-month-info-delete/{id}', [\App\Http\Controllers\BillMonthInfo\BillMonthController::class, 'delete'])->name('bill-month-info/bill-month-info-list');
    Route::get('electric_bill_report',[\App\Http\Controllers\ElectricBillReoprtController::class,'getPDF']);
    Route::get('electric_bill_check',[\App\Http\Controllers\ElectricBillReoprtController::class,'checkPdf']);
    Route::get('get-data',[\App\Http\Controllers\ElectricBillReoprtController::class,'testPdf']);
    Route::get('get-data-list',[\App\Http\Controllers\ElectricBillReoprtController::class,'testPdfList']);

    Route::get('meter-reading/meter-reading-common-master', [\App\Http\Controllers\MeterReding\MeterReadingController::class,'meterCommon'])->name('meter-reading/meter-reading-common-master');
    Route::get('report/meter-reading-bill', [\App\Http\Controllers\Report\ReportController::class, 'meter_bill'])->name('report/meter-reading-list');
    Route::get('report/pdf-meter-reading-bill', [\App\Http\Controllers\Report\ReportController::class, 'pdf_meter_bill'])->name('report/meter-reading-list');

    Route::get('rate/various-rate-info', [\App\Http\Controllers\Report\ReportController::class, 'various_rate_info'])->name('rate/various-rate-info');
    Route::get('meter-reading/meter-reading-common-master', [\App\Http\Controllers\MeterReding\MeterReadingController::class,'meterCommon'])->name('meter-reading/meter-reading-common-master');
    Route::get('opening-balance-by-department', [\App\Http\Controllers\Shop\BillGenerate\MonthWiseBillController::class,'OpeningBalanceByDepartment'])->name('opening-balance-by-department');
    Route::post('opening-balance-by-department', [\App\Http\Controllers\Shop\BillGenerate\MonthWiseBillController::class,'OpeningBalanceByDepartmentUpdate'])->name('opening-balance-by-department');



    //Reports
    //Electric bill by Meter
    Route::get('electric_bill_report_by_meter',[\App\Http\Controllers\ElectricBillReoprtController::class,'getPDF']);
    Route::get('electric_bill_report_by_meter_view',[\App\Http\Controllers\ElectricBillReoprtController::class,'reportByMeter']);

    //Electric Bill All Generate
    Route::get('electric_bill_report_download',[\App\Http\Controllers\ElectricBillReoprtController::class,'reportDownload']);
    Route::get('electric_bill_report',[\App\Http\Controllers\ElectricBillReoprtController::class,'getPDFAll']);
    Route::get('download-zip',[\App\Http\Controllers\ElectricBillReoprtController::class,'zipDownload']);
    Route::get('get-data-by-bcID',[\App\Http\Controllers\ElectricBillReoprtController::class,'getDataByBCid']);

    //Electric Bill check before publick
    Route::get('electric_bill_check',[\App\Http\Controllers\ElectricBillReoprtController::class,'checkPdf']);
    Route::get('electric_bill_check_view',[\App\Http\Controllers\ElectricBillReoprtController::class,'checkBillView']);

    //Electric Bill month wise
    Route::get('electric_bill_month_wise',[\App\Http\Controllers\ElectricBillReoprtController::class,'monthWise']);
    Route::get('electric_bill_month_wise_view',[\App\Http\Controllers\ElectricBillReoprtController::class,'monthWiseView']);

    Route::get('electric_bill_common_month_shop_wise_view',[\App\Http\Controllers\ElectricBillReoprtController::class,'commonMonthShopWiseView']);
    Route::get('electric_bill_common_month_shop_wise_pdf',[\App\Http\Controllers\ElectricBillReoprtController::class,'commonMonthShopWisePdf']);

    //Electric Bill Shop wise
    Route::get('electric_bill_shop_wise',[\App\Http\Controllers\ElectricBillReoprtController::class,'shopWise']);
    Route::get('electric_bill_shop_wise_view',[\App\Http\Controllers\ElectricBillReoprtController::class,'shopWiseView']);

    Route::get('electric_bill_shop_wise_view_shop',[\App\Http\Controllers\ElectricBillReoprtController::class,'shopWiseViewShop']);
    Route::get('electric_bill_shop_wise_view_shop_pdf',[\App\Http\Controllers\ElectricBillReoprtController::class,'shopWiseViewShopPdf']);

    //Shop Reports
    Route::get('shop_owner_details',[\App\Http\Controllers\ElectricBillReoprtController::class,'shopOwner']);
    Route::get('shop_owner_without_paymaster',[\App\Http\Controllers\ElectricBillReoprtController::class,'shopOwnerWithoutPaymaster']);
    Route::get('shop_owner_without_owner',[\App\Http\Controllers\ElectricBillReoprtController::class,'shopOwnerWithoutOwner']);

    //Namuna Chak
    Route::get('nomuna_chak',[\App\Http\Controllers\ElectricBillReoprtController::class,'nomuna_chak']);

    //Month Wise Sena Market Revenue
    Route::get('month_wise_sena_market_revenue_view',[\App\Http\Controllers\ElectricBillReoprtController::class,'monthWiseSenaMarketView']);
    Route::get('month_wise_sena_market_revenue_pdf',[\App\Http\Controllers\ElectricBillReoprtController::class,'monthWiseSenaMarketPdf']);

    Route::get('opening-balance-by-shop',[\App\Http\Controllers\ShopOpeningBalance::class,'opening_balance_by_Shop']);
    Route::post('opening-balance-bill-generate',[\App\Http\Controllers\ShopOpeningBalance::class,'opening_balance_bill_generate']);
    Route::post('current-month-bill-generate',[\App\Http\Controllers\ShopOpeningBalance::class,'current_month_bill_generate']);
    Route::get('settlement-by-shop',[\App\Http\Controllers\ShopOpeningBalance::class,'settlement_by_Shop']);
    Route::get('current-month-bill-by-shop',[\App\Http\Controllers\ShopOpeningBalance::class,'opening_balance_by_single_Shop']);
    Route::post('single-shop-data',[\App\Http\Controllers\ShopOpeningBalance::class,'single_shop_data']);
    Route::post('single-shop-data-store',[\App\Http\Controllers\ShopOpeningBalance::class,'single_shop_data_store']);

    Route::get('menu-list',[\App\Http\Controllers\MenuController::class,'index']);
    Route::get('menu-create',[\App\Http\Controllers\MenuController::class,'create']);
    Route::post('menu-create',[\App\Http\Controllers\MenuController::class,'store']);
    Route::get('menu-edit/{id}',[\App\Http\Controllers\MenuController::class,'edit']);
    Route::post('menu-edit/{id}',[\App\Http\Controllers\MenuController::class,'update']);
    Route::post('menu-delete/{id}',[\App\Http\Controllers\MenuController::class,'destroy']);

});
