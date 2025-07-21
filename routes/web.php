<?php

use App\AppConfig;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\RichText\Run;

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

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return 'All caches cleared!';
});

// ************************************************** API function form zms systme start code  ***************************************************

Route::get('suspend', function(Request $request){
    $message =  $request->message;
    return view('auth.suspend',compact('message'));
});

Route::get('/get-expiry-date', function () {
    $configurations = AppConfig::whereIn('config_name', ['client_id', 'next_time_interval'])->get()->pluck('config_value', 'config_name');
    $client_id = $configurations['client_id'];
    $expiryCheck_interval = $configurations['next_time_interval'];
    return response()->json([
        'client_id' => $client_id,
        'expiryCheck_interval' => $expiryCheck_interval,
    ]);
});

Route::post('/update-time-interval-date-update', function (Request $request) {
    $expiryCheck = AppConfig::where('config_name', 'next_time_interval')->first();
    if ($expiryCheck) {
        $expiryCheck->config_value = $request->next_time_interval;
        $expiryCheck->save();
        return response()->json('Update successful');
    }
    return response()->json('Config not found', 404);
});

Route::post('/get-expiry-date-update', function (Request $request) {
    $configs = ['next_time_interval', 'end_point', 'company_name'];
    $updated = false;
    foreach ($configs as $config) {
        $appConfig = AppConfig::where('config_name', $config)->first();
        if ($appConfig && $request->has($config)) {
            $appConfig->config_value = $request->input($config);
            $appConfig->save();
            $updated = true;
        }
    }
    if ($updated) {
        return response()->json('Update successful');
    }
    return response()->json('Config not found', 404);
});

Route::get('/requirement-list', 'ApiControllModuleController@requirement')->name('requirement-list');
Route::get('/moduls-list', 'ApiControllModuleController@moduls_list')->name('moduls-list');
Route::resource('app-configs','AppConfigController');
Route::post("app-config-edit-modal", "AppConfigController@setting_edit_modal")->name("app-config-edit-modal");


//************************************************ API function form zms systme end code  ***************************************************



// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', 'Auth\LoginController@loginf')->name('loginf');



Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    Artisan::call('optimize:clear');
    return back();
});

Route::get('/pdf/{id}', 'HomeController@pdf')->name('pdf');

Route::get('/search/ajax/{id}', 'HomeController@SearchAjax')->name('admin.masterAccSearchAjax');

Auth::routes();

// Testing URL
Route::get('/compare', 'HomeController@compare');
Route::get('/newReport', 'HomeController@newReport')->name('newReport');

Route::get('/repair-data-invoice-item-stock-sale-from-fifo', 'HomeController@repairinvitmstocksalefromfifo')->name('repairinvitmstocksalefromfifo');
Route::get('/invoicecheck', 'HomeController@invoice');
Route::get('/invoice-itemscheck/{invoice}', 'HomeController@invoiceItem')->name('invoiceItem');
Route::get('/invoice-delete', 'HomeController@invoice_delete')->name('invoice-delete');
//Mominul vai
Route::get('fifo-update', 'HomeController@fifo_update')->name('fifo-update');
Route::get('fifo-update-submit', 'HomeController@fifo_update_submit')->name('fifo-update-submit');
//End Testing URL

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/home', 'backend\ParentProfileController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){

    Route::resource('app-configs','AppConfigController');
    Route::post("app-config-edit-modal", "AppConfigController@setting_edit_modal")->name("app-config-edit-modal");
    // ************  api route to connect zms **************
    Route::get('/requirement-list', 'HomeController@requirement')->name('requirement-list');
    Route::get('/moduls-list', 'HomeController@moduls_list')->name('moduls-list');

    // ************  api route to connect zms **************

  Route::get('/dashboard', 'backend\DashboardController@index');
  Route::get('/form-layout', 'backend\DashboardController@form_layout');
  Route::get('/form-input', 'backend\DashboardController@form_input');
  Route::resource('role', 'backend\RoleController');
  Route::resource('settings','backend\SettingController');
  Route::resource('company-setup','backend\SetupController');
  Route::post('setup-edit-modal','backend\SetupController@setup_edit_modal')->name('setup-edit-modal');
  Route::post('/temp/document/upload/{id}','backend\DocumentController@tempDocumentUpload')->name('temp.document.uoload');
  Route::post('/document/upload/{id}','backend\DocumentController@documentUpload')->name('document.uoload');
  Route::get('/docuemnt/delete/{document}','backend\DocumentController@documentDelete')->name('document.destroy');
  Route::get('/temp/docuemnt/delete/{document}','backend\DocumentController@tempDocumentDelete')->name('temp.document.destroy');

    //setup start
    Route::prefix('/setup')->group(function(){
      Route::get('/report', 'ClientReportController@setupReport')->name('setup.report');
      Route::get('new-chart-of-account', 'backend\MasterAccountController@chart_of_account')->name('new-chart-of-account');
      Route::get('/cost-center-details', 'backend\CostCenterController@costCenterDetails')->name('costCenterDetails');
      Route::post('/project-details/Post', 'backend\ProjectController@projectDetailsPost')->name('projectDetailsPost');
      Route::get('/project-details/edit/{proj}', 'backend\ProjectController@projectEdit')->name('projectEdit');
      Route::get('/project-details/delete/{proj}', 'backend\ProjectController@projectDelete')->name('projectDelete');
      Route::get('new-account-head', 'backend\MasterAccountController@new_account_head')->name('new-account-head');
      Route::post('/project-details/Post1', 'backend\MasterAccountController@accHeahDetailsPost1')->name('accHeahDetailsPost1');
      Route::get('account-head', 'backend\MasterAccountController@account_head')->name('account-head1');
      Route::get("chart-ofaccount-pdf", "backend\MasterAccountController@chart_of_account_pdf")->name("chart-ofaccount-pdf");
      Route::get('/master-details/edit/{masterAcc}', 'backend\MasterAccountController@masterEdit')->name('masterEdit');
      Route::get('/master-details/delete/{masterAcc}', 'backend\MasterAccountController@masterDelete')->name('masterDelete');
      Route::post('/master-details/Post', 'backend\MasterAccountController@MasterDetailsPost')->name('masterDetailsPost');
      Route::post('/master-details/findMastedCode', 'backend\MasterAccountController@findMastedCode')->name('findMastedCode');
      Route::get('/findMasterAcc/{masterAcc}', 'backend\MasterAccountController@findMasterAcc')->name('findMasterAcc');
      Route::get('/editAccHead/{item}', 'backend\MasterAccountController@editAccHead')->name('editAccHead');
      Route::get('/acount-head/delete/{account_head}', 'backend\MasterAccountController@deleteAcHead')->name('deleteAcHead');
      Route::post('/project-details/Post/edit/{proj}', 'backend\ProjectController@projectDetailsUpdate')->name('projectDetailsUpdate');
      Route::post('/master-details/Post/edit/{masterAcc}', 'backend\MasterAccountController@masterDetailsUpdate')->name('masterDetailsUpdate');
      Route::get('/master-accounts-details', 'backend\MasterAccountController@masteAccDetails')->name('masteAccDetails');
      Route::post('/project-details/Post/{masterAcc}', 'backend\MasterAccountController@accHeahDetailsPost')->name('accHeahDetailsPost');
      Route::post('/project-details/edit/post/{account_head}', 'backend\MasterAccountController@accHeahEditPost')->name('accHeahEditPost');
      Route::get('/profit-details', 'backend\ProfitCenterController@ProfitCenterDetails')->name('profitCenterDetails');
      Route::get('/party-info', 'backend\PartyInfoController@partyInfoDetails')->name('partyInfoDetails');
      Route::resource('service-provider', 'backend\ServiceProviderController');
      Route::post('/costCenter/Post/', 'backend\CostCenterController@costCenterPost')->name('costCenterPost');
      Route::get('/profit-center/form', 'backend\ProfitCenterController@profitCenterForm')->name('profitCenterForm');
      Route::get('/cost-center/edit/{costCenter}', 'backend\CostCenterController@costCenEdit')->name('costCenEdit');
      Route::get('/cost-center/delete/{costCenter}', 'backend\CostCenterController@costCenDelete')->name('costCenDelete');
      Route::post('/cost-center/Post/edit/{costCenter}', 'backend\CostCenterController@costCentersUpdate')->name('costCentersUpdate');
      Route::get('/profit-center/edit/{profitCenter}', 'backend\ProfitCenterController@profitCenEdit')->name('profitCenEdit');
      Route::get('/profit-center/delete/{profitCenter}', 'backend\ProfitCenterController@profitCenDelete')->name('profitCenDelete');
      Route::post('/profit-center/Post/', 'backend\ProfitCenterController@profitCenterPost')->name('profitCenterPost');
      Route::post('/profit-center/Post/edit/{profitCenter}', 'backend\ProfitCenterController@profitCentersUpdate')->name('profitCentersUpdate');
      Route::get('/party-info/edit/{pInfo}', 'backend\PartyInfoController@partyInfoEdit')->name('partyInfoEdit');
      Route::get('/party-info/delete/{pinfo}', 'backend\PartyInfoController@partyInfoDelete')->name('partyInfoDelete');
      Route::post('/party-info/Post/', 'backend\PartyInfoController@partyInfoPost')->name('partyInfoPost');
      Route::post('party-ledger-modal', 'backend\AccountsReportController@party_report_modal')->name('party-ledger-modal');
      Route::post('/party-info/Post/edit/{profitCenter}', 'backend\PartyInfoController@partyInfoUpdate')->name('partyInfoUpdate');
      Route::get('/party-info/form/', 'backend\PartyInfoController@partyInfoForm')->name('partyInfoForm');

  });
  Route::post('projectView', 'backend\ProjectController@projectView')->name('projectView');
  Route::get('project-list-print', 'backend\ProjectController@project_list_print')->name('project-list-print');
  Route::post("party-center-preview", "backend\PartyInfoController@party_center_preview")->name("party-center-preview");

    // Project Details Starts
    Route::get('/project-details', 'backend\ProjectController@projectDetails')->name('projectDetails');
    Route::post('/project-details/Post', 'backend\ProjectController@projectDetailsPost')->name('projectDetailsPost');
    Route::get('/project-details/edit/{proj}', 'backend\ProjectController@projectEdit')->name('projectEdit');
    Route::post('/project-details/Post/edit/{proj}', 'backend\ProjectController@projectDetailsUpdate')->name('projectDetailsUpdate');
    Route::get('/project-details/delete/{proj}', 'backend\ProjectController@projectDelete')->name('projectDelete');
    Route::get('/project-details/form', 'backend\ProjectController@projectForm')->name('projectForm');
    Route::get('/project-details-view/{project}', 'backend\ProjectController@projectView')->name('projectView');
    // Project Details Ends

    // Bank Details Starts
    Route::get('/bank-details', 'backend\BankController@bankDetails')->name('bankDetails');
    Route::post('/bank-details/Post', 'backend\BankController@bankDetailsPost')->name('bankDetailsPost');
    Route::get('/bank-details/edit/{bank}', 'backend\BankController@bankEdit')->name('bankEdit');
    Route::post('/bank-details/Post/edit/{bank}', 'backend\BankController@bankDetailsUpdate')->name('bankDetailsUpdate');
    Route::get('/bank-details/delete/{bank}', 'backend\BankController@bankDelete')->name('bankDelete');
    Route::get('/bank-details/form/', 'backend\BankController@bankForm')->name('bankForm');
    // Bank Details Ends

    // Master Accounts Details Starts
    Route::get('/master-details/type', 'backend\MasterAccountController@mstAccType')->name('mstAccType');
    Route::post('/master-details/masterCatPost', 'backend\MasterAccountController@masterCatPost')->name('masterCatPost');
    Route::post('/master-details/masterAccType', 'backend\MasterAccountController@masterAccType')->name('masterAccType');
    // Master Accounts Details Ends


    // Account Head Details Starts
    Route::get('/accounts-head-details', 'backend\MasterAccountController@accHeadDetails')->name('accHeadDetails');
    Route::get('/cost-center/form/', 'backend\CostCenterController@costCenterForm')->name('costCenterForm');
    Route::get('/party-info-view/{pInfo}', 'backend\PartyInfoController@partyView')->name('partyView');

    // Tax Invoice Issue
    Route::get('/tax-invoice-issue', 'backend\TaxInvoiceController@taxInvoIssue')->name('taxInvoIssue');
    Route::get('/tax-invoice-issue/post', 'backend\TaxInvoiceController@taxInvoIssuepost')->name('taxInvoIssuepost');
    Route::post('select/item/by/term/', 'backend\TaxInvoiceController@selectItemByTerm')->name('selectItemByTerm');
    Route::post('party/info/by/term/', 'backend\TaxInvoiceController@partyInfoInvoice')->name('partyInfoInvoice');
    Route::post('find/date/', 'backend\TaxInvoiceController@findDate')->name('findDate');
    Route::post('find/item/', 'backend\TaxInvoiceController@findItem')->name('findItem');
    Route::post('find/item/edit', 'backend\TaxInvoiceController@findItemEdit')->name('findItemEdit');
    Route::get('temp/invoice/', 'backend\TaxInvoiceController@tempInvoice')->name('tempInvoice');
    Route::get('temp/invoice/edit', 'backend\TaxInvoiceController@tempInvoiceedit')->name('tempInvoiceedit');
    Route::post('preview/invoice/', 'backend\TaxInvoiceController@previewSaveInvoice')->name('previewSaveInvoice');
    Route::get('preview/invoice/view/{invoice}/{amountFrom}/{amountTo}', 'backend\TaxInvoiceController@invoicePreview')->name('invoicePreview');
    Route::get('preview/invoice/view/{invoice}/update', 'backend\TaxInvoiceController@updatePreviewInv')->name('updatePreviewInv');
    Route::post('final/invoice/', 'backend\TaxInvoiceController@finalSaveInvoice')->name('finalSaveInvoice');
    Route::get('invoicess/', 'backend\TaxInvoiceController@invoicess')->name('invoicess');
    Route::get('invoicePrint/{invoice}', 'backend\TaxInvoiceController@invoicePrint')->name('invoicePrint');
    Route::get('itemDelete/{item}', 'backend\TaxInvoiceController@itemDelete')->name('itemDelete');
    Route::get('refresh_invoice/', 'backend\TaxInvoiceController@refresh_invoice')->name('refresh_invoice');
    Route::get('tax-invoice-view/{invoice}', 'backend\TaxInvoiceController@invoiceView')->name('invoiceView');
    Route::get('tax-invoice-view/sale/{invoice}', 'backend\TaxInvoiceController@saleinvoiceView')->name('saleinvoiceView');
    Route::get('tax-invoice-view/2/{invoice}', 'backend\TaxInvoiceController@invoiceView2')->name('invoiceView2');
    Route::get('tax-invoice-edit/{invoice}', 'backend\TaxInvoiceController@invoiceEdit')->name('invoiceEdit');
    Route::post('tax-invoice-update/{invoice}', 'backend\TaxInvoiceController@finalSaveInvoiceUpdate')->name('finalSaveInvoiceUpdate');
    Route::post('find/item/id', 'backend\TaxInvoiceController@findItemId')->name('findItemId');
    Route::post('find/item/id/edit', 'backend\TaxInvoiceController@findItemIdedit')->name('findItemIdedit');
    Route::get('tax-invoice-list', 'backend\TaxInvoiceController@taxInvoiceList')->name('taxInvoiceList');
    Route::get('tax-invoice-search', 'backend\TaxInvoiceController@searchInvoice')->name('searchInvoice');
    Route::get('tax-invoice-search/sale', 'backend\TaxInvoiceController@searchSaleInvoice')->name('searchSaleInvoice');
    Route::post('amountto', 'backend\TaxInvoiceController@amountto')->name('amountto');
    Route::post('fifo/id', 'backend\TaxInvoiceController@quantityFifo')->name('quantityFifo');
    Route::post('fifo/id/edit', 'backend\TaxInvoiceController@quantityFifoedit')->name('quantityFifoedit');
    Route::get('tarek', 'backend\TaxInvoiceController@tarek')->name('tarek');
    Route::get('tarek-invo-update/{invoice}', 'backend\TaxInvoiceController@tarekInvUpdate')->name('tarekInvUpdate');
    Route::get('updateStock/{item}', 'backend\TaxInvoiceController@updateStock')->name('updateStock');
    Route::post('find/item/color', 'backend\TaxInvoiceController@findItemColor')->name('load_item.fetch');
    // End Tax Invoice Issue

    //Stock Position
    Route::get('/stock-position-details', 'backend\StockPositionController@stockPosition')->name('stockPosition');
    Route::get('/stock-position/search-month', 'backend\StockPositionController@searchStockPosition')->name('searchStockPosition');
    Route::get('/stock-position/search-date', 'backend\StockPositionController@searchStockPositionDate')->name('searchStockPositionDate');
    Route::get('/stock-position/search-range', 'backend\StockPositionController@searchStockPositionRange')->name('searchStockPositionRange');
    Route::get('/stock-position/with-purchase', 'backend\StockPositionController@stockReportWithP')->name('stockReportWithP');
    Route::get('/stock-position/search-date/with-purchase', 'backend\StockPositionController@searchStockPositionDateP')->name('searchStockPositionDateP');
    Route::get('/stock-position/search-range/with-purchase', 'backend\StockPositionController@searchStockPositionRangeP')->name('searchStockPositionRangeP');
    Route::get('/stock-position/print', 'backend\StockPositionController@printStockPosition')->name('printStockPosition');
    Route::get('/stock-position/print/date/{date}', 'backend\StockPositionController@printStockPositionDate')->name('printStockPositionDate');
    Route::get('/stock-position/print/range/{from}/{to}', 'backend\StockPositionController@printStockPositionRange')->name('printStockPositionRange');
    Route::get('/stock-position/purchase/print', 'backend\StockPositionController@printStockPositionP')->name('printStockPositionP');
    Route::get('/stock-position/purchase/print/date/{date}', 'backend\StockPositionController@printStockPositionDateP')->name('printStockPositionDateP');
    Route::get('/stock-position/purchase/print/range/{from}/{to}', 'backend\StockPositionController@printStockPositionRangeP')->name('printStockPositionRangeP');
    Route::get('/stock-position-report', 'backend\StockPositionController@stockPosition2')->name('stockPosition2');
    Route::get('/stock-position-report/print', 'backend\StockPositionController@printStockPosition2')->name('printStockPosition2');
    Route::get('/stock-position-report/date/{date}/print', 'backend\StockPositionController@printStockPosition2Date')->name('printStockPosition2Date');
    Route::get('/stock-position-report/range/{from}/{to}/print', 'backend\StockPositionController@printStockPosition2Range')->name('printStockPosition2Range');

    //End Stock Position

    //Journal Entry
    Route::get('/journal-entry', 'backend\JournalEntryController@journalEntry')->name('journalEntry');
    Route::post('find-project', 'backend\JournalEntryController@findProject')->name('findProject');
    Route::post('find-cost-center', 'backend\JournalEntryController@findCostCenter')->name('findCostCenter');
    Route::post('find-cost-center/id', 'backend\JournalEntryController@findCostCenterId')->name('findCostCenterId');
    Route::post('party/info/by/term2/', 'backend\JournalEntryController@partyInfoInvoice2')->name('partyInfoInvoice2');
    Route::post('party/info/by/term3/', 'backend\JournalEntryController@partyInfoInvoice3')->name('partyInfoInvoice3');

    Route::post('find-account-head', 'backend\JournalEntryController@findAccHead')->name('findAccHead');
    Route::post('find-account-head/id', 'backend\JournalEntryController@findAccHeadId')->name('findAccHeadId');
    Route::post('find-tax_rate', 'backend\JournalEntryController@findTaxRate')->name('findTaxRate');
    Route::post('find-findamount', 'backend\JournalEntryController@findamount')->name('findamount');
    Route::post('journal-entry/post', 'backend\JournalEntryController@journalEntryPost')->name('journalEntryPost');
    Route::get('journal-entry/edit/{journal}', 'backend\JournalEntryController@journalEdit')->name('journalEdit');
    Route::post('journal-entry/edit-post/{journal}', 'backend\JournalEntryController@journalEntryEditPost')->name('journalEntryEditPost');
    Route::get('/journal/delete/{journal}', 'backend\JournalEntryController@journalDelete')->name('journalDelete');
    Route::get('/journal-authorize', 'backend\JournalEntryController@journalAuthorize')->name('journalAuthorize');
    Route::get('/journal-entry/view/{journal}', 'backend\JournalEntryController@journalView')->name('journalView');
    Route::get('/journal-authorize/{journal}', 'backend\JournalEntryController@journalMakeAuthorize')->name('journalMakeAuthorize');
    Route::post('journal/auth-decline/{journal}', 'backend\JournalEntryController@journaAuthDecline')->name('journaAuthDecline');
    Route::get('/journal-approve/{journal}', 'backend\JournalEntryController@journalMakeApprove')->name('journalMakeApprove');
    Route::post('journal/approve-decline/{journal}', 'backend\JournalEntryController@journaApproveDecline')->name('journaApproveDecline');
    Route::get('/journal-approval', 'backend\JournalEntryController@journalApproval')->name('journalApproval');
    Route::get('/journals', 'backend\JournalEntryController@Journals')->name('Journals');
    Route::get('/approved-journal/view/{journal}', 'backend\JournalEntryController@ApprovedjournalView')->name('ApprovedjournalView');

    Route::get('journal-success/{id}', 'backend\JournalEntryController@journal_success')->name('journal-success');
    Route::get("journal-edit/{id}", "backend\JournalEntryController@journal_edit")->name("journal_edit");
    //End Journal Entry


      // Sale order receive
      Route::get('/sale-order', 'backend\SaleOrderController@saleOrderReceive')->name('saleOrderReceive');
      Route::post('party/info/by/term/for-sale', 'backend\SaleOrderController@SalePartyInfo')->name('SalePartyInfo');
      Route::post('find/date/for-sale', 'backend\SaleOrderController@findDateSale')->name('findDateSale');
      Route::post('find/item/for-sale', 'backend\SaleOrderController@findItemSale')->name('findItemSale');
      Route::post('find/item/id/for-sale', 'backend\SaleOrderController@findItemIdSale')->name('findItemIdSale');
      Route::get('temp/sale-order/', 'backend\SaleOrderController@tempSaleOrder')->name('tempSaleOrder');
      Route::get('itemDelete/for-sale/{item}', 'backend\SaleOrderController@itemDeleteSale')->name('itemDeleteSale');
      Route::post('final/sale-order/', 'backend\SaleOrderController@finalSaveSaleOrder')->name('finalSaveSaleOrder');
      Route::get('sale-order-print/{invoice}', 'backend\SaleOrderController@saleOrderPrint')->name('saleOrderPrint');
      Route::get('refresh/sale-order', 'backend\SaleOrderController@refresh_sale_order')->name('refresh_sale_order');
      Route::get('sale-order/view/{sale}', 'backend\SaleOrderController@saleOrderView')->name('saleOrderView');
      Route::get('sale-order-edit/{invoice}', 'backend\SaleOrderController@saleOrderEdit')->name('saleOrderEdit');
      Route::post('sale_order-update/{invoice}', 'backend\SaleOrderController@finalSaveSaleUpdate')->name('finalSaveSaleUpdate');
      Route::get('search-sale-order', 'backend\SaleOrderController@searchSO')->name('searchSO');
      Route::post('/customer/Post/', 'backend\SaleOrderController@customerPost')->name('customerPost');
      Route::post('add-new-customerPost', 'backend\SaleOrderController@add_new_customerPost')->name('add-new-customerPost');
      // End sale order

       //Delivery Note
       Route::get('/delivery-note', 'backend\DeliveryNoteController@deliveryNote')->name('deliveryNote');
       Route::get('/sale-order-details/{sale}', 'backend\DeliveryNoteController@saleOrderDetails')->name('saleOrderDetails');
       Route::get('/delivery-note-view/{dNote}', 'backend\DeliveryNoteController@deliveryNoteView')->name('deliveryNoteView');
       Route::post('/assing-delivery-note/{sale}', 'backend\DeliveryNoteController@asignDeliveryNote')->name('asignDeliveryNote');
       Route::get('/delivery-note-update/{invoice}', 'backend\DeliveryNoteController@updateNote')->name('updateNote');
       Route::get('delivery-note-print/{invoice}', 'backend\DeliveryNoteController@deliveryNotePrint')->name('deliveryNotePrint');
       Route::post('/generate-delivery-note/{sale}', 'backend\DeliveryNoteController@generateDeliveryNote')->name('generateDeliveryNote');
       Route::get('delivery-note/search-sale-order', 'backend\DeliveryNoteController@searchSODNo')->name('searchSODNo');
       Route::get('delivery-note/find', 'backend\DeliveryNoteController@findDNo')->name('findDNo');
       Route::get('delivery-note/search-sale-order/month', 'backend\DeliveryNoteController@searchSODNoMonth')->name('searchSODNoMonth');
       Route::get('delivery-note/search-sale-order/date', 'backend\DeliveryNoteController@searchSODNoDate')->name('searchSODNoDate');
       Route::get('delivery-note/search-sale-order/date-range', 'backend\DeliveryNoteController@searchSODNoDateRange')->name('searchSODNoDateRange');
       Route::get('delivery-note-list/', 'backend\DeliveryNoteController@dnList')->name('dnList');
       Route::get('delivery-note-details/{dNote}', 'backend\DeliveryNoteController@deliveryNoteDetails')->name('deliveryNoteDetails');
       Route::get('delivery-note-find/month', 'backend\DeliveryNoteController@findDNoMonth')->name('findDNoMonth');
       Route::get('delivery-note/find/date', 'backend\DeliveryNoteController@findDNoDate')->name('findDNoDate');
       Route::get('delivery-note/find/date-range', 'backend\DeliveryNoteController@findDNoDateRange')->name('findDNoDateRange');
       Route::get('delivery-summary', 'backend\DeliveryNoteController@deliverySummery')->name('deliverySummery');
       Route::get('delivery-details/deliveryNotesummery/{dnote}', 'backend\DeliveryNoteController@deliveryNotesummery')->name('deliveryNotesummery');
       Route::get('delivery-note/search/summary', 'backend\DeliveryNoteController@searchDNo')->name('searchDNoS');
       Route::get('delivery-note-search/summary/month', 'backend\DeliveryNoteController@searchDNoMonth')->name('searchDNoMonthS');
       Route::get('delivery-note/search/summary/date', 'backend\DeliveryNoteController@searchDNoDate')->name('searchDNoDateS');
       Route::get('delivery-note/search/summary/date-range', 'backend\DeliveryNoteController@searchDNoDateRange')->name('searchDNoDateRangeS');
       Route::get('tax-invoice-issue/sales/invoice/{invoice}', 'backend\DeliveryNoteController@deliveryNoteInvoice')->name('deliveryNoteInvoice');
       //End delivery note

      //Sales Return
      Route::get('/sales-return', 'backend\SalesReturnController@salesReturn')->name('salesReturn');
      Route::post('find/invoice/for-return', 'backend\SalesReturnController@findsaleInvoice')->name('findsaleInvoice');
      Route::get('temp/sale-order-return/', 'backend\SalesReturnController@tempSaleOrderReturn')->name('tempSaleOrderReturn');
      Route::post('final/sale-return/', 'backend\SalesReturnController@finalSaveSaleReturn')->name('finalSaveSaleReturn');
      Route::get('sale-return-print/{invoice}', 'backend\SalesReturnController@saleReturnPrint')->name('saleReturnPrint');
      Route::get('sale-return-details/{invoice}', 'backend\SalesReturnController@saleReturnDetails')->name('saleReturnDetails');
      Route::get('refresh_sale-return/', 'backend\SalesReturnController@refresh_saleReturn')->name('refresh_saleReturn');
      Route::post('find/item/id/for-return', 'backend\SalesReturnController@findItemIdSaleReturn')->name('findItemIdSaleReturn');
      Route::get('find/item/qty/saleReturnQty', 'backend\SalesReturnController@saleReturnQty')->name('saleReturnQty');
      //End Sales Return

      //Sale Tax invoice issue
    Route::get('tax-invoice-issue/sales', 'backend\TaxInvoiceController@salesTaxtInvoiceIssue')->name('salesTaxtInvoiceIssue');
    Route::get('tax-invoice-details/sale-order/{sale}', 'backend\TaxInvoiceController@saleOrderTaxInvoice')->name('saleOrderTaxInvoice');
    Route::get('/tax-invoice-generate/sale-order/{sale}', 'backend\TaxInvoiceController@genTaxInvoiceSO')->name('genTaxInvoiceSO');
    Route::get('delivery-details/sale-order/{dnote}', 'backend\TaxInvoiceController@deliveryNotInvoice')->name('deliveryNotInvoice');
    Route::get('/tax-invoice-generate/delivery-note/{dnote}', 'backend\TaxInvoiceController@genTaxInvoiceDN')->name('genTaxInvoiceDN');
    Route::get('delivery-note/search', 'backend\TaxInvoiceController@searchDNo')->name('searchDNo');
    Route::get('delivery-note-search/month', 'backend\TaxInvoiceController@searchDNoMonth')->name('searchDNoMonth');
    Route::get('delivery-note/search/date', 'backend\TaxInvoiceController@searchDNoDate')->name('searchDNoDate');
      //end sales tax invoice issue

    //   Report
        Route::get('daily-sale-report', 'backend\ReportController@dailySaleReport')->name('dailySaleReport');
    Route::get('daily-sale-report/print', 'backend\ReportController@printDailySale')->name('printDailySale');
    Route::get('daily-sale-report/date', 'backend\ReportController@searchDailySale')->name('searchDailySale');
    Route::get('daily-sale-report/date-range', 'backend\ReportController@searchDailySaleRange')->name('searchDailySaleRange');
    Route::get('/daily-sale-report/date-range/print/{from}/{to}', 'backend\ReportController@printDailySaleDateRange')->name('printDailySaleDateRange');
    Route::get('monthly-sale-report', 'backend\ReportController@monthlySaleReport')->name('monthlySaleReport');
    Route::get('invoice-wise-sale-summary', 'backend\ReportController@InvoiceWiseSaleSummary')->name('InvoiceWiseSaleSummary');
    Route::get('daily-sale-report/print/date/{date}', 'backend\ReportController@printDailySaleDate')->name('printDailySaleDate');
    Route::get('daily-sale-report/print/date/range/{from}/{to}', 'backend\ReportController@printDailySaleDateRange')->name('printDailySaleDateRange');
    Route::get('delivery-note/search/date-range', 'backend\ReportController@searchDNoDateRange')->name('searchDNoDateRange');
    Route::get('/invoice-wise-sales/search-date', 'backend\ReportController@searchinvoiceWIseDate')->name('searchinvoiceWIseDate');
    Route::get('/invoice-wise-sales/search-range', 'backend\ReportController@searchinvoiceWIseRange')->name('searchinvoiceWIseRange');
    Route::post('/filterInvoiceWiseSaleReport', 'backend\ReportController@filterInvoiceWiseSaleReport')->name('filterInvoiceWiseSaleReport');
    Route::get('/invoice-wise-daily-sales', 'backend\ReportController@invoiceWiseDailySalePrint')->name('invoiceWiseDailySalePrint');
    Route::get('/invoice-wise-daily-sales/{date}', 'backend\ReportController@invoiceWiseDailySalePrintDate')->name('invoiceWiseDailySalePrintDate');
    Route::get('/invoice-wise-daily-sales/range/{from}/{to}', 'backend\ReportController@invoiceWiseDailySalePrintRange')->name('invoiceWiseDailySalePrintRange');
    Route::get('/monthly-sale-report', 'backend\ReportController@monthylySale')->name('monthly-sale-report');
    Route::get('/monthly-sale-report/print/{month?}', 'backend\ReportController@monthlySaleReportPrint')->name('monthlySaleReportPrint');
    //Report End
    //Work by Tarek end
  // work start by mominul

    // mapping
    Route::resource('mapping', 'backend\MappingController');
    Route::post('account-head', 'backend\MappingController@account_head')->name('account-head');
    Route::post('account-code', 'backend\MappingController@account_code')->name('account-code');
    // style
    Route::resource('style', 'backend\StyleController');
    // brands


    //purchase start
    Route::get('check-invoice', 'backend\purchaseExpenseController@check_invoice_no')->name('check-invoice');

    Route::get('temp/purchase/service', 'backend\PurchaseController@purchaseTemp')->name('purchaseTemp');
    Route::post('preview/purchase/', 'backend\PurchaseController@previewSavePurchase')->name('previewSavePurchase');
    Route::get('preview/purchase/view/{purchase}/', 'backend\PurchaseController@PurchasePreview')->name('PurchasePreview');
    Route::post('final/purchase/', 'backend\PurchaseController@finalSavePurchase')->name('finalSavePurchase');
    Route::get('purchase-view/{invoice}', 'backend\PurchaseController@purchaseView')->name('purchaseView');
    Route::get('purchasePrint/{invoice}', 'backend\PurchaseController@purchasePrint')->name('purchasePrint');
    Route::get('itemPurchDelete/{item}', 'backend\PurchaseController@itemPurchDelete')->name('itemPurchDelete');
    Route::get('purchase-search', 'backend\PurchaseController@searchPurchase')->name('searchPurchase');
    Route::get('party-wish-report', 'backend\PurchaseController@party_wish_report')->name('party-wish-report');

    Route::post('unit.fetch', 'backend\ProductController@unit_fatch')->name('unit.fetch');

    Route::get('purchaseDuePay/', 'backend\PurchaseController@purchaseDuePay')->name('purchaseDuePay');
    Route::get('refresh_purchase/', 'backend\PurchaseController@refresh_purchase')->name('refresh_purchase');

    Route::get('/invoice-wise-daily-purchase/{date}', 'backend\PurchaseController@purchasePrintDate')->name('purchasePrintDate');
    Route::get('/purchasePrintRange/{from}/{to}', 'backend\PurchaseController@purchasePrintRange')->name('purchasePrintRange');
    Route::get('/purchasePrint2/report', 'backend\PurchaseController@purchasePrintreport2')->name('purchasePrintreport2');

    Route::post('brand-add-modal', 'backend\BrandController@brandAddModal')->name('brand-add-modal');

    Route::post('brand-edit-modal', 'backend\BrandController@brandEditModal')->name('brand-edit-modal');
    Route::resource('sub-brand', 'backend\SubBrandController');
    Route::post('sub-brand-add-modal', 'backend\SubBrandController@subBrandAddModal')->name('sub-brand-add-modal');
    // === Shagor Purchase Order ====


    // group
    Route::resource('group', 'backend\GroupController');
    // list item
    Route::resource('item-list', 'backend\ItemListController');
    Route::post('vat-type-value', 'backend\ItemListController@vat_type_value')->name('vat-type-value');
    Route::post('item-type-no', 'backend\ItemListController@item_type_no')->name('item-type-no');
    Route::post('group-id', 'backend\ItemListController@group_id')->name('group-id');
    Route::post('brand-country', 'backend\ItemListController@brand_country')->name('brand-country');
    Route::get('item-delete/{id}', 'backend\ItemListController@item_delete')->name('item-list.item-delete');
    Route::post('excel-file-import', 'backend\ItemListController@import')->name('excel-file-import');
    Route::post('partyInfo_import-excel-file-import', 'backend\PartyInfoController@partyInfo_import')->name('partyInfo_import-excel-file-import');
    Route::post('style-id', 'backend\StyleController@style_id')->name('style-id');
    Route::post("item-barcode", "backend\ItemListController@item_barcode")->name("item-barcode");
    Route::post("item-barcode-check", "backend\ItemListController@item_barcode_check")->name("item-barcode-check");
    Route::post("item-name-auto-select", "backend\ItemListController@item_name_auto_select")->name("item-name-auto-select");
    Route::get("items-download", "backend\ItemListController@items_download")->name("items-download");
    // purchase requisition
    Route::resource('purchase-requisition', 'backend\PurchaseRequisitionController');

    Route::post("one-po-item-delete", "backend\PurchaseDetailController@one_po_item_delete")->name("one-po-item-delete");
    Route::post("one-po-item-edit", "backend\PurchaseDetailController@one_po_item_edit")->name("one-po-item-edit");
    Route::get("editor-pr-process/{id}", "backend\PurchaseRequisitionController@editor_pr_process")->name("editor-pr-process");
    Route::get('authorize-requisition', 'backend\PurchaseRequisitionController@authorize_requisition')->name('authorize-requisition');
    Route::get('authorize-requisition-details/{id}', 'backend\PurchaseRequisitionController@authorize_requisition_details')->name('authorize-requisition-details');
    Route::get('authorize-pr-submit/{id}', 'backend\PurchaseRequisitionController@authorize_pr_submit')->name('authorize-pr-submit');
    Route::get('approve-requisition', 'backend\PurchaseRequisitionController@approve_requisition')->name('approve-requisition');
    Route::get('approve-requisition-details/{id}', 'backend\PurchaseRequisitionController@approve_requisition_details')->name('approve-requisition-details');
    Route::get('approve-pr-submit/{id}', 'backend\PurchaseRequisitionController@approve_pr_submit')->name('approve-pr-submit');
    Route::post('item-list-get', 'backend\PurchaseRequisitionController@item_list_get')->name('item-list-get');
    Route::post('purchase-requisition-item-store', 'backend\PurchaseRequisitionDetailController@purchase_requisition_item_store')->name('purchase-requisition-item-store');
    Route::get('purchase-requisitin-aprove/{id}', 'backend\PurchaseRequisitionController@purchase_requisitin_aprove')->name('purchase-requisitin-aprove');
    Route::get('pr-item-list-delete/{id}', 'backend\PurchaseRequisitionDetailController@pr_item_delete')->name('pr-item-list-delete');
    Route::post('item-qty-get', 'backend\PurchaseRequisitionDetailController@item_qty_get')->name('item-qty-get');
    Route::post('project-name-get', 'backend\PurchaseRequisitionDetailController@project_name_get')->name('project-name-get');
    Route::get("authorize-pr-rejected/{id}", "backend\PurchaseRequisitionController@authorize_pr_rejected")->name("authorize-pr-rejected");
    Route::get("approver-pr-rejected/{id}", "backend\PurchaseRequisitionController@approver_pr_rejected")->name("approver-pr-rejected");
    Route::post("authorize-pr-reviece", "backend\PurchaseRequisitionController@authorize_pr_reviece")->name("authorize-pr-reviece");
    Route::post("approve-pr-reviece", "backend\PurchaseRequisitionController@approve_pr_reviece")->name("approve-pr-reviece");
    Route::get("rejected-requisition", "backend\PurchaseRequisitionController@rejected_requisition")->name("rejected-requisition");
    Route::get("revise-requisition-authorize", "backend\PurchaseRequisitionController@reviece_requisition_authorize")->name("revise-requisition-authorize");
    Route::get("revise-requisition-editor", "backend\PurchaseRequisitionController@reviece_requisition_editor")->name("revise-requisition-editor");
    Route::get('pr-print/{id}', 'backend\PurchaseRequisitionController@pr_print')->name('pr-print');
    Route::post("delete-previouse-pr-item", "backend\PurchaseRequisitionController@delete_previouse_pr_item")->name("delete-previouse-pr-item");
    Route::post("delete-previouse-pr-item-one", "backend\PurchaseRequisitionDetailController@delete_previouse_pr_item_one")->name("delete-previouse-pr-item-one");
    Route::post("pr-filter", "backend\PurchaseRequisitionController@pr_filter")->name("pr-filter");
    // Item purchases
    Route::resource('purchase-temp', 'backend\PurchaseTempController');
    Route::get("purchase-process/{id}", "backend\PurchaseController@purchase_process")->name("purchase-process");
    Route::get("po-generation-approval-list", "backend\PurchaseController@po_generation_approval_list")->name("po-generation-approval-list");
    Route::get("approve-po-submit/{id}", "backend\PurchaseController@approve_po_submit")->name("approve-po-submit");
    Route::post("approve-po-reviece", "backend\PurchaseController@approve_po_reviece")->name("approve-po-reviece");
    Route::get("po-generation-approval-details/{id}", "backend\PurchaseController@po_generation_approval_details")->name("po-generation-approval-details");
    Route::get("po-generation-revise-list", "backend\PurchaseController@po_generation_revise_list")->name("po-generation-revise-list");
    Route::post('purchase-temp-trasfer', 'backend\PurchaseController@purchase_temp_trasfer')->name('purchase-temp-trasfer');
    Route::resource('item-purchase', 'backend\PurchaseDetailController');
    Route::post("po-filter", "backend\PurchaseController@po_filter")->name("po-filter");
    Route::post('all-po-item-delete', 'backend\PurchaseDetailController@all_po_item_delete')->name('all-po-item-delete');
    Route::get('purchase-print/{id}', 'backend\PurchaseDetailController@purchase_print')->name('purchase-print');
    Route::post('supplier-information', 'backend\PurchaseDetailTempController@supplier_information')->name('supplier-information');
    Route::post('po-item-store', 'backend\PurchaseDetailController@po_item_store')->name('po-item-store');
    Route::get('temp-item-list-delete/{id}', 'backend\PurchaseDetailTempController@temp_item_delete')->name('temp-item-list-delete');
    // Goods Receive
    Route::resource('goods-received', 'backend\GoodsReceivedController');
    Route::get('gr-details/{id}', 'backend\GoodsReceivedController@gr_details')->name('gr-details');
    Route::get("gr-print/{id}", "backend\GoodsReceivedController@gr_print")->name("gr-print");
    Route::post("gr-list-show", "backend\GoodsReceivedController@gr_list_show")->name("gr-list-show");
    // purchase returm
    Route::resource("purchase-return", 'backend\PurchaseReturnController');
    Route::get('pt-details/{id}', 'backend\PurchaseReturnController@pt_details')->name('pt-details');
    Route::get('pr-return/{id}', 'backend\PurchaseReturnController@pt_return')->name('pr-return');
    Route::get("purchase-return-authorize", "backend\PurchaseReturnController@purchase_return_authorize")->name("purchase-return-authorize");
    Route::get("purchase-return-approval", "backend\PurchaseReturnController@purchase_return_approval")->name("purchase-return-approval");
    Route::get("pt-authorize-details/{id}", "backend\PurchaseReturnController@pt_authorize_details")->name("pt-authorize-details");
    Route::post("authorize-pt-reviece", "backend\PurchaseReturnController@authorize_pt_reviece")->name("authorize-pt-reviece");
    Route::get("purchase-return-revise", "backend\PurchaseReturnController@purchase_return_revise")->name("purchase-return-revise");
    Route::post("purchase-return-item-store", "backend\PurchaseReturnDetailController@purchase_return_item_store")->name("purchase-return-item-store");
    Route::post("pt-item-barcode", "backend\PurchaseReturnDetailController@pt_item_barcode")->name('pt-item-barcode');
    Route::get("temp-return-item-list-delete/{id}", "backend\PurchaseReturnDetailController@temp_return_item_list_delete")->name("temp-return-item-list-delete");
    Route::get("authorize-pt-rejected/{id}", "backend\PurchaseReturnController@authorize_pt_rejected")->name("authorize-pt-rejected");
    Route::get("pt-rejected-list-authorize", "backend\PurchaseReturnController@pt_rejected_list_authorize")->name("pt-rejected-list-authorize");
    Route::get("pt-rejected-list-editor", "backend\PurchaseReturnController@pt_rejected_list_editor")->name("pt-rejected-list-editor");
    Route::get("authorize-pt-submit/{id}", "backend\PurchaseReturnController@authorize_pt_submit")->name("authorize-pt-submit");
    Route::get("pt-approval-details/{id}", "backend\PurchaseReturnController@pt_approval_details")->name("pt-approval-details");
    Route::post("approval-pt-reviece", "backend\PurchaseReturnController@approval_pt_reviece")->name("approval-pt-reviece");
    Route::get("revise-pt-authorize-list", "backend\PurchaseReturnController@revise_pt_authorize_list")->name("revise-pt-authorize-list");
    Route::get("approval-pt-rejected/{id}", "backend\PurchaseReturnController@approval_pt_rejected")->name("approval-pt-rejected");
    Route::get("pt-approval-process/{id}", "backend\PurchaseReturnController@pt_approval_process")->name("pt-approval-process");
    Route::get("pt-print/{id}", "backend\PurchaseReturnController@pt_print")->name("pt-print");
    Route::post("pt-filter", "backend\PurchaseReturnController@pt_filter")->name("pt-filter");
    // payment-voucher
    Route::resource("payment-voucher", "backend\PaymentVoucherController");
    Route::get("pv-process/{id}", "backend\PaymentVoucherController@pv_process")->name("pv-process");
    Route::get("pv-create/{id}", "backend\PaymentVoucherController@pv_create")->name("pv-create");
    Route::get("pending-pv-authorize", "backend\PaymentVoucherController@pending_pv_authorize")->name("pending-pv-authorize");
    Route::get("pv-authorize-view/{id}", "backend\PaymentVoucherController@pv_authorize_view")->name("pv-authorize-view");
    Route::post("revise-pv-submit-authorizer", "backend\PaymentVoucherController@revise_pv_submit_authorizer")->name("revise-pv-submit-authorizer");
    Route::get("rejected-pv-authorizer/{id}", "backend\PaymentVoucherController@rejected_pv_authorizer")->name("rejected-pv-authorizer");
    Route::get("rejected-pv-all-editor", "backend\PaymentVoucherController@rejected_pv_all_editor")->name("rejected-pv-all-editor");
    Route::get("pv-approve-authorizer/{id}", "backend\PaymentVoucherController@pv_approve_authorizer")->name("pv-approve-authorizer");
    Route::get("pending-pv-approval", "backend\PaymentVoucherController@pending_pv_approval")->name("pending-pv-approval");
    Route::get("pv-approval-view/{id}", "backend\PaymentVoucherController@pv_approval_view")->name("pv-approval-view");
    Route::post("revise-pv-submit-approval", "backend\PaymentVoucherController@revise_pv_submit_approval")->name("revise-pv-submit-approval");
    Route::get("revise-pv-all-editor", "backend\PaymentVoucherController@revise_pv_all_editor")->name("revise-pv-all-editor");
    Route::get("revise-pv-authorizer-approver", "backend\PaymentVoucherController@revise_pv_authorizer_approver")->name("revise-pv-authorizer-approver");
    Route::get("rejected-pv-approver/{id}", "backend\PaymentVoucherController@rejected_pv_approver")->name("rejected-pv-approver");
    Route::get("rejected-pv-authorize", "backend\PaymentVoucherController@rejected_pv_authorize")->name("rejected-pv-authorize");
    Route::get("pv-approve-approval/{id}", "backend\PaymentVoucherController@pv_approve_approval")->name("pv-approve-approval");
    Route::get("approve-pv-view/{id}", "backend\PaymentVoucherController@approve_pv_view")->name("approve-pv-view");
    Route::get("pv-pdf-print/{id}", "backend\PaymentVoucherController@pv_pdf_print")->name("pv-pdf-print");
    Route::post("pv-filter", "backend\PaymentVoucherController@pv_filter")->name("pv-filter");
    // Receipt Voucher
    Route::resource("receipt-voucher", "backend\ReceiptVoucherController");
    Route::get("invoice-details/{id}", "backend\ReceiptVoucherController@invoice_details")->name("invoice-details");
    Route::get("receipt-voucher-create/{id}", "backend\ReceiptVoucherController@receipt_voucher_create")->name("receipt-voucher-create");
    Route::get("receipt-voucher-process/{id}", "backend\ReceiptVoucherController@receipt_voucher_process")->name("receipt-voucher-process");
    Route::get("receipt-voucher-print/{id}", "backend\ReceiptVoucherController@receipt_voucher_print")->name("receipt-voucher-print");
    Route::get("receipt-voucher-approval-list", "backend\ReceiptVoucherController@receipt_voucher_approval_list")->name("receipt-voucher-approval-list");
    Route::get("approve-rv-details/{id}", "backend\ReceiptVoucherController@approve_rv_details")->name("approve-rv-details");
    Route::post("approve-rv-reviece", "backend\ReceiptVoucherController@approve_rv_reviece")->name("approve-rv-reviece");
    Route::get("approver-rv-approve/{id}", "backend\ReceiptVoucherController@approver_rv_approve")->name("approver-rv-approve");
    Route::get("rv-revise-list", "backend\ReceiptVoucherController@rv_revise_list")->name("rv-revise-list");
    Route::get("rv-revise-update/{id}", "backend\ReceiptVoucherController@rv_revise_update")->name("rv-revise-update");
    Route::post("rv-revise-update-complete/{id}", "backend\ReceiptVoucherController@rv_revise_update_complete")->name("rv-revise-update-complete");
    Route::post("rv-filter", "backend\ReceiptVoucherController@rv_filter")->name("rv-filter");


     // purchase summary report
  Route::resource("purchase-summary", "backend\PurchaseSummaryController");
  Route::get('purchase-summery/date', 'backend\PurchaseSummaryController@searchDailyPurch')->name('searchDailyPurch');
  Route::get('purchase-summery/date-range', 'backend\PurchaseSummaryController@searchDailyPurchageRange')->name('searchDailyPurchageRange');
  Route::get('purchase-summary-print', 'backend\PurchaseSummaryController@printPurchaseSummery')->name('printPurchaseSummery');
  Route::get('purchase-summery-print/date/{date}', 'backend\PurchaseSummaryController@printPurchaseSummeryDate')->name('printPurchaseSummeryDate');
  Route::get('purchase-summery-print/range/{from}/{to}', 'backend\PurchaseSummaryController@printPurchaseSummeryRange')->name('printPurchaseSummeryRange');


  // work end by mominul

  // work end by mominul



 // Shagor: Invoice Posting
Route::get('invoice-posting', 'backend\InvoicePosting@index')->name('invoice_posting');
Route::get('invoice-posting/{id}', 'backend\InvoicePosting@invoice_post_form')->name('invoice_post_form');
Route::post('invoice-posting-submit','backend\InvoicePosting@invoice_posting_submit')->name('invoice-posting-submit');
Route::get('ip-details/{id}', 'backend\InvoicePosting@ip_details')->name('ip_details');
// users
Route::resource('user','backend\UserController');

Route::get('business-summary-report', 'backend\ExpenseController@businessSummery')->name('businessSummery');
Route::get('business-summary-report-print/{date?}/{to?}', 'backend\ExpenseController@businessSummaryprint')->name('businessSummaryprint');


// expense
Route::resource('expense', 'backend\ExpenseController');
Route::post('expense-get-account-head','backend\ExpenseController@get_account_heads')->name('expense_get_account_head');

Route::resource('document','backend\DocumentController');
Route::post('document-search', 'backend\DocumentController@search')->name('document-search');

Route::get('under-const', 'HomeController@under_construction')->name('under-const');


// Accounts Report
Route::get('general-ledger', 'backend\AccountsReportController@general_ledger')->name('general-ledger');
Route::get('general-ledger/date-range', 'backend\AccountsReportController@general_ledger_by_date_range')->name('general-ledger-by-date-range');
Route::get('general-ledger/date', 'backend\AccountsReportController@general_ledger_by_date')->name('general-ledger-by-date');
Route::get('general-ledger/print', 'backend\AccountsReportController@general_ledger_print')->name('print-gl');
Route::get('general-ledger/print/date/{date}', 'backend\AccountsReportController@general_ledger_print_date')->name('print-gl-date');
Route::get('general-ledger/print/date/range/{from}/{to}', 'backend\AccountsReportController@general_ledger_print_date_range')->name('print-gl-date-range');

Route::get('accounts-payable-ledger', 'backend\AccountsReportController@ac_payable_ledger')->name('ac-payable-ledger');

Route::get('accounts-receivable-ledger', 'backend\AccountsReportController@ac_receivable_ledger')->name('ac-receivable-ledger');



Route::get('trial-balance', 'backend\AccountsReportController@trial_balance')->name('trial-balance');
Route::get('trial-balance/date', 'backend\AccountsReportController@trial_balance_date')->name('trial-balance-date');
Route::get('trial-balance/date-range', 'backend\AccountsReportController@trial_balance_date_range')->name('trial-balance-date-range');
Route::get('trial-balance/print', 'backend\AccountsReportController@trial_balance_print')->name('trial-balance-print');
Route::get('trial-balance/print/date/{date}', 'backend\AccountsReportController@trial_balance_print_date')->name('trial-balance-print-date');
Route::get('trial-balance/print/date-range/{from}/{to}', 'backend\AccountsReportController@trial_balance_print_date_range')->name('trial-balance-print-date-range');


// new receipt voucher
Route::get('receipt-voucher','backend\NewReceiptVoucher@receipt_voucher_form')->name('form-receipt-voucher');
Route::POST('get-invoice-details','backend\NewReceiptVoucher@get_invoice_details')->name('get-invoice-details');
Route::POST('receipt-voucher-store','backend\NewReceiptVoucher@receipt_voucher_store')->name('store-receipt-voucher');
Route::get('receipt-voucher-print/{id}','backend\NewReceiptVoucher@receipt_voucher_print')->name('store-receipt-print');
// new receipt voucher: by mominul
Route::get('new-receipt-voucher','backend\NewReceiptVoucher@new_receipt_voucher')->name('new-receipt-voucher');
Route::get("receipt-voucher-list", "backend\NewReceiptVoucher@receipt_voucher_list")->name("receipt-voucher-list");
Route::post("receipt-voucher-details-modal", "backend\NewReceiptVoucher@receipt_voucher_details_modal")->name("receipt-voucher-details-modal");
Route::get("receipt-voucher-view-pdf/{id}", "backend\NewReceiptVoucher@receipt_voucher_view_pdf")->name("receipt-voucher-view-pdf");

Route::get('receipt-voucher-authorize','backend\NewReceiptVoucher@voucher_authorize')->name('receipt-voucher-authorize');
Route::post("receipt-voucher-authorize-modal", "backend\NewReceiptVoucher@authorize_modal")->name("receipt-voucher-authorize-modal");
Route::get('receipt-voucher-make-authorize/{id}','backend\NewReceiptVoucher@make_authorize')->name('receipt-voucher-make-authorize');
Route::get('receipt-voucher-approval','backend\NewReceiptVoucher@voucher_approval')->name('receipt-voucher-approval');
Route::post("receipt-voucher-approval-modal", "backend\NewReceiptVoucher@approval_modal")->name("receipt-voucher-approval-modal");
Route::get('receipt-voucher-make-approve/{id}','backend\NewReceiptVoucher@make_approve')->name('receipt-voucher-make-approve');


// Debit voucher
Route::get('voucher-details/{id}','backend\JournalEntryController@voucher_details')->name('voucher-details');
Route::get('debit-voucher/','backend\JournalEntryController@debit_voucher')->name('debit-voucher');
Route::get('credit-voucher/','backend\JournalEntryController@credit_voucher')->name('credit-voucher');
Route::get('journal-voucher/','backend\JournalEntryController@journal_voucher')->name('journal-voucher');

Route::prefix('/vehicle')->group(function(){
    Route::get('/report', 'ClientReportController@vehicle')->name('vehicle.report');
    Route::resource('vehicle','backend\TruckController');
    Route::get('vehicle-service-report', 'backend\TruckController@vehicle_service_report')->name('vehicle-service-report');
    Route::resource('driver', 'backend\DriverController');
    Route::resource('material', 'backend\MaterialController');
    Route::resource('crusher', 'backend\CursherController');
    Route::resource('destination', 'backend\DestinationController');
    Route::resource('rate','backend\RateController');
    Route::post("toll-name-store", "backend\RateController@toll_store")->name("toll-name-store");

});
//Truck
Route::POST('get-a-vehicle','backend\TruckController@get_a_vehicle')->name('get-a-vehicle');
Route::POST('update-vehicle','backend\TruckController@update_vehicle')->name('update-vehicle');
Route::POST('get-a-record','backend\TruckController@get_a_record')->name('get-a-record');
Route::POST('update-record','backend\TruckController@update_record')->name('update-record');
Route::POST('get-truck-details','backend\TruckController@get_a_truck')->name('get-truck-details');

Route::get('shagor-add','backend\TruckController@test_1');
Route::get('shagor-remove','backend\TruckController@test_2');

Route::prefix('/customer-inv')->group(function(){
  Route::get('/report', 'ClientReportController@customer_inv')->name('customer-inv.report');
  Route::get('driver-report', 'backend\DriverController@driver_report')->name('driver-report');
  Route::get('vehicle-report','backend\TruckController@vehicle_report')->name('vehicle-report');

});
Route::get('vehicle-service','backend\TruckController@truck_service')->name('vehicle-service');
Route::POST('vehicle-service','backend\TruckController@save_truck_service')->name('save-truck-service');
Route::POST('check-service-serial','backend\TruckController@check_truck_service_serial')->name('check-service-serial');
Route::get('delete-vehicle-service/{id}','backend\TruckController@delete_service')->name('delete-vehicle-service');
Route::POST('add-to-sessions','backend\TruckController@add_to_session')->name('add-to-session');
Route::POST('remove-session-item','backend\TruckController@remove_item_from_session')->name('remove-session-item');
Route::get('customer-invoice-process', 'backend\CustomerInvoiceController@customer_invoice_process')->name('customer-invoice_process');
Route::POST('customer-invoice-save', 'backend\CustomerInvoiceController@save_customer_invoice')->name('save-customer-invoice');
Route::POST('customer-invoice-update', 'backend\CustomerInvoiceController@update_customer_invoice')->name('update-customer-invoice');
Route::get('invoice-list', 'backend\CustomerInvoiceController@invoice_list')->name('invoice-list');
Route::get('tax-invoice-print/{id}', 'backend\CustomerInvoiceController@invoice_print')->name('invoice-print');


// Payment voucher
Route::get('payment-voucher','backend\NewPaymentVoucher@payment_voucher_form')->name('payment-voucher');
Route::POST('get-supplier-invoice-details','backend\NewPaymentVoucher@get_invoice_details')->name('get-supplier-invoice-details');
Route::POST('payment-voucher-store','backend\NewPaymentVoucher@payment_voucher_store')->name('store-payment-voucher');
Route::get('payment-voucher-print/{id}','backend\NewPaymentVoucher@payment_voucher_print')->name('payment-voucher-print');
Route::get("payment-voucher-list", "backend\NewPaymentVoucher@payment_voucher_list")->name("payment-voucher-list");
Route::post("payment-voucher-details-modal", "backend\NewPaymentVoucher@payment_voucher_details_modal")->name("payment-voucher-details-modal");
Route::get("payment-voucher-view-pdf/{id}", "backend\NewPaymentVoucher@payment_voucher_view_pdf")->name("receipt-voucher-view-pdf");

//work by tarek
Route::get("authorize-payment-voucher-list", "backend\NewPaymentVoucher@authorize_payment_voucher_list")->name("authorize-payment-voucher-list");
Route::get('payment-voucher-make-authorize/{id}','backend\NewPaymentVoucher@make_authorize')->name('payment-voucher-make-authorize');
Route::get("approval-payment-voucher-list", "backend\NewPaymentVoucher@approval_payment_voucher_list")->name("approval-payment-voucher-list");
Route::post("appr-payment-voucher-details-modal", "backend\NewPaymentVoucher@appr_payment_voucher_details_modal")->name("appr-payment-voucher-details-modal");

Route::get('authorize-payment-voucher/{type?}/{id}', 'backend\CustomerInvoiceController@authorize_invoice')->name('authorize-payment-voucher');


// Shagor End


// Party ledger by Tarek
Route::get('party-ledger', 'backend\PartyLedgerController@partyLedger')->name('partyLedger');
Route::get('find/party-ledger', 'backend\PartyLedgerController@findPartyLedgers')->name('findPartyLedgers');
Route::get('find/party-ledger/date', 'backend\PartyLedgerController@findPartyLedgersDate')->name('findPartyLedgersDate');
Route::get('find/party-ledger/{from}/{to}/{party}', 'backend\PartyLedgerController@printLedger')->name('printLedger');
Route::get('finds/party-ledger/date/{date}/{party}', 'backend\PartyLedgerController@printLedgerDate')->name('printLedgerDate');



//  new work by mominul 12/10/2022
Route::get('new-chart-of-account', 'backend\MasterAccountController@chart_of_account')->name('new-chart-of-account');
Route::get("chart-ofaccount-pdf", "backend\MasterAccountController@chart_of_account_pdf")->name("chart-ofaccount-pdf");
Route::get('new-journal', 'backend\JournalEntryController@new_journal')->name('new-journal');
Route::get("journal-approval-section", "backend\JournalEntryController@journal_approval_section")->name("journal-approval-section");
Route::post("journal-authorize-show-modal", "backend\JournalEntryController@journal_authorize_show_modal")->name("journal-authorize-show-modal");
Route::post("journal-approval-show-modal", "backend\JournalEntryController@journal_approval_show_modal")->name("journal-approval-show-modal");
Route::get("new-journal-creation", "backend\JournalEntryController@new_journal_creation")->name("new-journal-creation");
Route::post('journal-creation-section', 'backend\JournalEntryController@journal_creation_section')->name('journal-creation-section');
Route::post('voucher-details-modal', 'backend\JournalEntryController@voucher_details_modal')->name('voucher-details-modal');
Route::post('voucher-preview-modal', 'backend\JournalEntryController@voucher_preview_modal')->name('voucher-preview-modal');
Route::get('journal-authorization-section', 'backend\JournalEntryController@journal_authorization_section')->name('journal-authorization-section');
Route::post('journal-add-new-head', 'backend\JournalEntryController@journal_add_new_head')->name('journal-add-new-head');
Route::get('new-expense', 'backend\ExpenseController@new_expense')->name("new-expense");
Route::post("party-center-preview", "backend\PartyInfoController@party_center_preview")->name("party-center-preview");
// acconts report
Route::get('new-general-ledger', 'backend\AccountsReportController@new_general_ledger')->name('new-general-ledger');
Route::get('new-general-ledger/date-range', 'backend\AccountsReportController@new_general_ledger_by_date_range')->name('new-general-ledger-by-date-range');
Route::get('new-general-ledger/date', 'backend\AccountsReportController@new_general_ledger_by_date')->name('new-general-ledger-by-date');
Route::get('new-trial-balance', 'backend\AccountsReportController@new_trial_balance')->name('new-trial-balance');
Route::get('new-trial-balance/date', 'backend\AccountsReportController@new_trial_balance_date')->name('new-trial-balance-date');
Route::get('new-trial-balance/date-range', 'backend\AccountsReportController@new_trial_balance_date_range')->name('new-trial-balance-date-range');
Route::get('new-accounts-payable-ledger', 'backend\AccountsReportController@new_accounts_payable_ledger')->name('new-accounts-payable-ledger');
Route::get('new-accounts-receivable-ledger', 'backend\AccountsReportController@new_accounts_receivable_ledger')->name('new-accounts-receivable-ledger');
Route::get('new-party-ledger', 'backend\PartyLedgerController@new_party_ledger')->name('new-party-ledger');

//work by tarek
Route::get('new-general-ledger/filter', 'backend\AccountsReportController@new_general_filter')->name('new-general-filter');
Route::get('new-general-ledger/filter-all', 'backend\AccountsReportController@new_general_filter_all')->name('new-general-filter-range-all');
Route::get('new-general-ledger/filter-range', 'backend\AccountsReportController@new_general_filter_range')->name('new-general-filter-range');

// 15/10/2022
Route::get("new-mapping", "backend\MappingController@new_mapping")->name("new-mapping");
Route::post("new-find-account-head", "backend\MappingController@new_find_account_head")->name("new-find-account-head");
Route::get('new-account-head', 'backend\MasterAccountController@new_account_head')->name('new-account-head');
Route::post("new-account-code", "backend\MappingController@new_account_code")->name("new-account-code");
Route::post("mapping-edit-modal", "backend\MappingController@mapping_edit_modal")->name("mapping-edit-modal");
Route::get("new-project-details", "backend\ProjectController@new_project_details")->name("new-project-details");
Route::post("business-edit-modal", "backend\ProjectController@business_edit_modal")->name("business-edit-modal");
Route::post("business-view-modal", "backend\ProjectController@business_view_modal")->name("business-view-modal");
Route::get("new-bank-details", "backend\BankController@new_bank_details")->name("new-bank-details");
Route::post("bank-details-edit-modal", "backend\BankController@bank_details_edit_modal")->name("bank-details-edit-modal");
Route::get('get-party-info/{id}', 'backend\PartyInfoController@get_party_info')->name('get-party-info');
Route::get('journal-view-pdf/{id}', 'backend\JournalEntryController@journal_view_pdf')->name('journal-view-pdf');
Route::get('tem-journal-view-pdf/{id}', 'backend\JournalEntryController@tem_journal_view_pdf')->name('tem-journal-view-pdf');
Route::get('new-receipt-voucher','backend\NewReceiptVoucher@new_receipt_voucher')->name('new-receipt-voucher');
Route::get("receipt-voucher-list", "backend\NewReceiptVoucher@receipt_voucher_list")->name("receipt-voucher-list");
// Route::post("receipt-voucher-details-modal", "backend\NewReceiptVoucher@receipt_voucher_details_modal")->name("receipt-voucher-details-modal");
Route::get("receipt-voucher-view-pdf/{id}", "backend\NewReceiptVoucher@receipt_voucher_view_pdf")->name("receipt-voucher-view-pdf");

Route::get("b-summary-report", "backend\PartyLedgerController@b_summary_report")->name("b-summary-report");
Route::get("updateinvoicedate", "backend\PartyLedgerController@updateinvoicedate")->name("updateinvoicedate");
// mominul end: new design

Route::get('authorize-invoice/{type?}/{id}', 'backend\CustomerInvoiceController@authorize_invoice')->name('authorize-invoice');
Route::get('decline-invoice/{id}', 'backend\CustomerInvoiceController@decline_invoice')->name('decline-invoice');
// draft invoice
Route::get('draft-invoice-submit/{id}', 'backend\CustomerInvoiceController@draft_invoice_submit')->name('draft-invoice-submit');
Route::get('delete-customer-inv/{id}', 'backend\CustomerInvoiceController@delete_invoice')->name('delete-customer-inv');
Route::get('decline-invoice-edit/{id}', 'backend\CustomerInvoiceController@decline_invoice_edit')->name('decline-invoice-edit');
Route::post('decline-customer-invoice-update/{id}', 'backend\CustomerInvoiceController@decline_customer_invoice_update')->name('decline-customer-invoice-update');

Route::get('tax-invoice-print/{id}', 'backend\CustomerInvoiceController@invoice_print')->name('invoice-print');
Route::get('customer-invoice-sum-print/{id}', 'backend\CustomerInvoiceController@invoice_sum_print')->name('customer-invoice-sum-print');
Route::get('temp-customer-invoice-sum-print/{id}', 'backend\CustomerInvoiceController@temp_invoice_sum_print')->name('temp-customer-invoice-sum-print');
// Mominul: customer invoice search
Route::get('search-supplier-invoice', 'backend\SupplierInvoiceController@search_supplier_invoice')->name('search-supplier-invoice');

Route::post('excel-import', 'backend\TruckController@excel_import')->name('excel-import');

Route::post('projectView', 'backend\ProjectController@projectView')->name('projectView');
Route::get('project-list-print', 'backend\ProjectController@project_list_print')->name('project-list-print');
Route::get('bank-list-print', 'backend\BankController@bank_lint_print')->name('bank-list-print');
// user access
Route::post("role-edit-modal", "backend\RoleController@role_edit_modal")->name("role-edit-modal");
Route::post("user-edit-modal", "backend\UserController@user_edit_modal")->name("user-edit-modal");
Route::post("setting-edit-modal", "backend\SettingController@setting_edit_modal")->name("setting-edit-modal");
Route::get('draft-invoice-print/{id}', 'backend\CustomerInvoiceController@draft_invoice_print')->name('draft-invoice-print');
Route::POST('draft-customer-invoice-save/{id}', 'backend\CustomerInvoiceController@draft_save_customer_invoice')->name('draft-save-customer-invoice');

Route::post('multiple-draft-invoice', 'backend\CustomerInvoiceController@multiple_draft_invoice')->name('multiple-draft-invoice');
Route::post('multiple-authorize-invoice', 'backend\CustomerInvoiceController@multiple_authorize_invoice')->name('multiple-authorize-invoice');
Route::post('multiple-approval-invoice', 'backend\CustomerInvoiceController@multiple_approval_invoice')->name('multiple-approval-invoice');

Route::post('update-receipt-voucher/{id}', 'backend\NewReceiptVoucher@update_receipt_voucher')->name('update-receipt-voucher');
Route::get('receipt-voucher-rejected/{id}', 'backend\NewReceiptVoucher@receipt_voucher_rejected')->name('receipt-voucher-rejected');
Route::get('receipt-voucher-reject-list', 'backend\NewReceiptVoucher@receipt_voucher_reject_list')->name('receipt-voucher-reject-list');
Route::get('payment-voucher-edit/{id}', 'backend\NewPaymentVoucher@payment_voucher_edit')->name('payment-voucher-edit');
Route::post('update-payment-voucher/{id}', 'backend\NewPaymentVoucher@update_payment_voucher')->name('update-payment-voucher');
Route::get('payment-voucher-rejected/{id}', 'backend\NewPaymentVoucher@payment_voucher_rejected')->name('payment-voucher-rejected');
Route::get('payment-voucher-reject-list', 'backend\NewPaymentVoucher@payment_voucher_reject_list')->name('payment-voucher-reject-list');

Route::post('truck-service-add', 'backend\CustomerInvoiceController@truck_service_add')->name('truck-service-add');
Route::post('truck-service-process', 'backend\CustomerInvoiceController@truck_service_process')->name('truck-service-process');
Route::post('truck-service-delete', 'backend\TruckController@truck_service_delete')->name('truck-service-delete');
Route::post('remove-truck_id-session', 'backend\CustomerInvoiceController@remove_truck_id_session')->name('remove-truck_id-session');
// vehicle expense
Route::post('driver-commission-update', 'backend\VehicleExpenseController@driver_commission_update')->name('driver-commission-update');
Route::get('driver-commission', 'backend\VehicleExpenseController@driver_commission')->name('driver-commission');
Route::post('driver-detail-view', 'backend\VehicleExpenseController@driver_detail_view')->name('driver-detail-view');
Route::get('driver-commission-print', 'backend\VehicleExpenseController@driver_commission_print')->name('driver-commission-print');
Route::get('vehicle-expense-reports', 'backend\VehicleExpenseController@vehicle_expense_reports')->name('vehicle-expense-reports');
Route::get('customer-invoice-reports', 'backend\CustomerInvoiceController@customer_invoice_reports')->name('customer-invoice-reports');
Route::get('item-stock-position', 'backend\StockPositionController@item_stock_position')->name('item-stock-position');
Route::get('product-purchase-sale-report/{id}', 'backend\StockPositionController@product_purchase_sale_report')->name('product-purchase-sale-report');
Route::post('item.fetch', 'backend\ProductController@itemFatch')->name('item.fetch');
Route::post('categoryProduct.fetch', 'backend\ProductController@categoryProduct')->name('categoryProduct.fetch');
Route::get('/stock-position-report/product/print/{products}', 'backend\StockPositionController@printStockPositionItem')->name('printStockPositionItem');
Route::get('/stock-position-report/category/print/{category}', 'backend\StockPositionController@printStockPositionCat')->name('printStockPositionCat');
// toll fees recharge and payment
Route::get('service-reports', 'backend\SupplierInvoiceController@service_reports')->name('service-reports');
Route::get('find-stock', 'backend\VehicleExpenseController@find_stock')->name('find-stock');
Route::get('check-excel-import', 'backend\TruckController@check_excel_import')->name('check-excel-import');
Route::post('delete-excel-truck-entry', 'backend\TruckController@delete_excel_truck_entry')->name('delete-excel-truck-entry');
Route::resource('toll-fee-invoice', 'backend\TollFeeInvoiceController');
Route::post('toll-fee-invoice-confirm', 'backend\TollFeeInvoiceController@toll_fee_invoice_confirm')->name('toll-fee-invoice-confirm');
Route::get('toll-fee-invoice-sum-print/{id}', 'backend\TollFeeInvoiceController@toll_fee_invoice_sum_print')->name('toll-fee-invoice-sum-print');
Route::post('filal-excel-import', 'backend\TruckController@filal_excel_import')->name('filal-excel-import');
Route::post('truck-service-export', 'backend\TruckController@truck_service_export')->name('truck-service-export');
Route::post('driver-edit-model', 'backend\DriverController@driver_edit_model')->name('driver-edit-model');
Route::post('material-edit-model', 'backend\MaterialController@material_edit_model')->name('material-edit-model');
Route::post('crusher-edit-model', 'backend\CursherController@crusher_edit_model')->name('crusher-edit-model');
Route::post('destination-edit-model', 'backend\DestinationController@destination_edit_model')->name('destination-edit-model');
Route::get('third-party-report', 'backend\CustomerInvoiceController@third_party_report')->name('third-party-report');
Route::get('toll-name-wise-report', 'backend\TollFeesPaymentController@toll_name_wise_report')->name('toll-name-wise-report');
Route::get('vehicle-wise-toll-report', 'backend\TollFeesPaymentController@vehicle_wise_toll_report')->name('vehicle-wise-toll-report');
Route::get('toll-fee-report', 'backend\TollFeesPaymentController@toll_fee_report')->name('toll-fee-report');
// 04/09/2023 work by habib
  //payroll
  Route::resource("employees", "backend\Payroll\EmployeeController");
  Route::resource("employee-banks", "backend\Payroll\EmployeeBankController");
  Route::resource("employee-salary", "backend\Payroll\EmployeeSalaryController");
  Route::resource("salary-structures", "backend\Payroll\SalaryComponentController");
  Route::resource("grade-wise-salary-components", "backend\Payroll\GradeWiseSalaryComponentController");
  Route::resource("salary-types", "backend\Payroll\SalaryTypesController");
  Route::resource("grades", "backend\Payroll\GradeController");
  Route::resource("pay-salary", "backend\Payroll\PaySalaryController");
  Route::resource('nationality', 'backend\Payroll\NationalityController');
  Route::resource('department', 'backend\Payroll\DepartmentController');
  Route::resource('country-code', 'backend\Payroll\CountryCodeController');
  Route::resource('branch', 'backend\Payroll\BankBranchController');
  Route::resource('salary-process', 'backend\Payroll\SalaryprocessController');
  Route::resource('time-tracking', 'backend\Payroll\TimeTrackController');
  Route::resource('grade-wise-leave-list', 'backend\Payroll\GradeWiseLeaveListController');
  Route::resource('leave-management', 'backend\Payroll\LeaveManagementController');
  Route::resource('performance-management', 'backend\Payroll\PerformanceController');
  Route::resource('employee-history', 'backend\Payroll\EmployeeHistoryController');
  Route::resource('employee-document', 'backend\Payroll\EmployeeDocumentController');
  Route::get("salary-process-start", "backend\Payroll\SalaryprocessController@crearteSalary")->name("salary-process-start");
  Route::post("salary-process-confirm", "backend\Payroll\SalaryprocessController@confirm")->name("salary-process-confirm");
  Route::get('employee/name', 'backend\Payroll\EmployeeBankController@employeeInfo')->name('employee-name');
  Route::get('routing/number', 'backend\Payroll\EmployeeBankController@bankInfo')->name('routing-number');
  Route::get("salary-crearte", "backend\Payroll\SalaryController@crearteSalary")->name("salary-crearte");
  Route::get("base-table", "backend\Payroll\NationalityController@base")->name("base-table");
  Route::post('percent/', 'backend\Payroll\SalaryController@percentCount')->name('percentCount');
  Route::get('generate-pdf','backend\Payroll\PDFController@generatePDF');
  Route::get('generate-payslip','backend\Payroll\PDFController@generatePayslip')->name('generate-payslip');
  Route::get('pay-salary-print/{id}','backend\Payroll\PDFController@pay_salary_print')->name('pay-salary-print');
  Route::get('generate-management-report','backend\Payroll\PDFController@generateManagementReport')->name('generate-management-report');
  Route::get('print-document','backend\Payroll\PaySalaryController@printDocument')->name('print-document');
  Route::get('employee-time-tracking', 'backend\Payroll\TimeTrackController@employeeInfo')->name('employee-time-tracking');
  Route::get('leave-info', 'backend\Payroll\LeaveManagementController@employeeInfo')->name('leave-info');
  Route::post("employee-leave-edit-modal", "backend\Payroll\LeaveManagementController@employee_leave_edit_modal")->name("employee-leave-edit-modal");
  Route::get('employeeLeaveDocumentDelete/{id}', 'backend\Payroll\LeaveManagementController@employeeLeaveDocumentDelete')->name('employeeLeaveDocumentDelete');
  Route::post("employee-view-leave-modal", "backend\Payroll\LeaveManagementController@employee_view_leave_modal")->name("employee-view-leave-modal");
  Route::get('time-entry/{id}/{status}', 'backend\Payroll\TimeTrackController@timeEntry')->name('time-entry');
  Route::get('employeeProDocumentDelete/{id}', 'backend\Payroll\EmployeeController@employeeProDocumentDelete')->name('employeeProDocumentDelete');
  Route::get('employee-view-profile-modal', 'backend\Payroll\EmployeeController@employeePriview')->name('employee-view-profile-modal');
  Route::get("employee-history-view", "backend\Payroll\EmployeeHistoryController@employee_history_view")->name("employee-history-view");
  Route::get("employee-document-view", "backend\Payroll\EmployeeDocumentController@employee_history_view")->name("employee-document-view");
  Route::get("employee-document-edit/{id}", "backend\Payroll\EmployeeDocumentController@employeeDocumentEdit")->name("employee-document-edit");
  Route::post("employee-document-update/{id}", "backend\Payroll\EmployeeDocumentController@employeeDocumentUpdate")->name("employee-document-update");
  Route::get("professional-document-update/{id}", "backend\Payroll\EmployeeDocumentController@professionalDocumentEdit")->name("professional-document-edit");
  Route::post("professional-document-update", "backend\Payroll\EmployeeDocumentController@professionalDocumentUpdate")->name("professional-document-update");
  Route::get("history-document-edit/{id}", "backend\Payroll\EmployeeDocumentController@historyDocumentEdit")->name("history-document-edit");
  Route::post("history-document-update", "backend\Payroll\EmployeeDocumentController@historyDocumentUpdate")->name("history-document-update");
  Route::get('employee-search', 'backend\Payroll\EmployeeController@employeeInfo')->name('employee-search');
  Route::get('history-search', 'backend\Payroll\EmployeeHistoryController@historyInfo')->name('history-search');
  Route::get('document-search', 'backend\Payroll\EmployeeDocumentController@documentInfo')->name('document-search');
  Route::resource('labour-expense', 'backend\LabourExpenseController');
  Route::get('labour-expense-add', 'backend\LabourExpenseController@labour_expense_add')->name('labour-expense-add');
  Route::GET('labour-salary-per-hour', 'backend\LabourExpenseController@labour_salary_per_hour')->name('labour-salary-per-hour');
  Route::post('labour-expense-view-modal', 'backend\LabourExpenseController@labour_expense_view_modal')->name('labour-expense-view-modal');
  Route::post('check-account-head', 'backend\JournalEntryController@check_account_head')->name('check-account-head');
  Route::get('purchase-due-payment', 'backend\PurchaseController@purchase_due_payment')->name('purchase-due-payment');
  Route::get('purchase-due-pay/{id}', 'backend\PurchaseController@purchase_due_pay')->name('purchase-due-pay');
  Route::post('final-due-payment', 'backend\PurchaseController@final_due_payment')->name('final-due-payment');
  Route::get('/party-info-unique','backend\PartyInfoController@checkUniqueParty')->name('chack.unique.party');
  Route::post('rate-edit-model', 'backend\RateController@rate_edit_model')->name('rate-edit-model');
  Route::post('check-exit-rate', 'backend\RateController@check_exit_rate')->name('check-exit-rate');
  Route::post('check-exit-tkt-number', 'backend\RateController@check_exit_tkt_number')->name('check-exit-tkt-number');
  // Route::resource('token-gereration', 'backend\TokenGenerationController');
  Route::post('add-new-truckPost', 'backend\TruckController@add_new_truckPost')->name('add-new-truckPost');
  Route::post('add-new-materialPost', 'backend\MaterialController@add_new_materialPost')->name('add-new-materialPost');
  Route::get('cusher-destination-report', 'backend\CustomerInvoiceController@cusher_destination_report')->name('cusher-destination-report');
  Route::post('check-exit-toll-fee', 'backend\RateController@check_exit_toll_fee')->name('check-exit-toll-fee');
  Route::post('check-vehicle-number', 'backend\TruckController@check_vehicle_number')->name('check-vehicle-number');
  Route::post('check-tkt-number', 'backend\TruckController@check_tkt_number')->name('check-tkt-number');
  Route::post('get-token-info', 'backend\VehicleExpenseController@get_token_info')->name('get-token-info');
  Route::post('excel-filter', 'backend\TruckController@excel_filter')->name('excel-filter');
  Route::post('update-temp-excel-upload', 'backend\TruckController@update_temp_excel_upload')->name('update-temp-excel-upload');
  Route::post('check-tkt-number-duplicated', 'backend\TruckController@check_tkt_number_duplicated')->name('check-tkt-number-duplicated');
  Route::post('get-product-info', 'backend\ProductController@get_product_info')->name('get-product-info');
  // payroll
  Route::prefix('/hr/payroll')->group(function(){
    Route::get("new-employee-attendance", "backend\EmployeeAttendence@new_employee_attendance")->name("new-employee-attendance");
    Route::get("new-employee-leave", "backend\EmployeeLeaveController@new_employee_leave")->name("new-employee-leave");

    Route::get('/report', 'ClientReportController@hrReport')->name('hr.payroll.report');
    Route::resource("employees", "backend\Payroll\EmployeeController");
    Route::resource('division', 'backend\Payroll\DivisionController');
    Route::resource('department', 'backend\Payroll\DepartmentController');
    Route::resource("salary-types", "backend\Payroll\SalaryTypesController");
    Route::resource('nationality', 'backend\Payroll\NationalityController');
    Route::resource('branch', 'backend\Payroll\BankBranchController');
    Route::resource('grade-wise-leave-list', 'backend\Payroll\GradeWiseLeaveListController');
    Route::resource("grade-wise-salary-components", "backend\Payroll\GradeWiseSalaryComponentController");
    Route::resource("employee-salary", "backend\Payroll\EmployeeSalaryController");
    Route::resource("salary-structures", "backend\Payroll\SalaryComponentController");
    Route::resource('deduction-entry', 'backend\Payroll\DeductionEntryController');
    Route::resource('salary-process', 'backend\Payroll\SalaryprocessController');
    Route::resource("pay-salary", "backend\Payroll\PaySalaryController");
    Route::resource("grades", "backend\Payroll\GradeController");
    Route::resource('employee-history', 'backend\Payroll\EmployeeHistoryController');
    Route::resource('employee-document', 'backend\Payroll\EmployeeDocumentController');
    Route::get("pay-request", "backend\Payroll\PaySalaryController@payRequest")->name('pay-request');
    Route::post('pay-salary-view', 'backend\Payroll\PaySalaryController@pay_salary_view')->name('pay-salary-view');
  });

  Route::get('find-currency', 'backend\Payroll\EmployeeController@findCurrency')->name('find-currency');
  Route::get('find-currency', 'backend\Payroll\EmployeeController@findCurrency')->name('find-currency');
  Route::get('employees-approve/{id}', 'backend\Payroll\EmployeeController@approve')->name('employees-approve');
  Route::get('employees-edit-approve/{id}', 'backend\Payroll\EmployeeController@editApprove')->name('employees-edit-approve');
  Route::resource('employee-attendance','backend\EmployeeAttendence');
  Route::post('employee-attendance/index','backend\EmployeeAttendence@index')->name('search_em_attend');
  Route::post('search-holiday-recode', 'backend\EmployeeAttendence@search_holiday_recode')->name('search-holiday-recode');
  Route::post('get_sections', 'backend\EmployeeAttendence@get_sections')->name('get_sections');
  Route::get('employee-attendance-print', 'backend\EmployeeAttendence@employee_attendance_print')->name('employee-attendance-print');
  // employee leave
  Route::resource('employee-leave', 'backend\EmployeeLeaveController');
  Route::get('employee-leave-print/{id}', 'backend\EmployeeLeaveController@employee_leave_print')->name('employee-leave-print');
  Route::post("employee-leave-print-modal", "backend\EmployeeLeaveController@employee_leave_print_modal")->name("employee-leave-print-modal");
  Route::post("employee-leave-upload-scan-copy-modal", "backend\EmployeeLeaveController@employee_leave_upload_scan_copy_modal")->name("employee-leave-upload-scan-copy-modal");

  Route::get("new-employee-attendance-edit", "backend\EmployeeAttendence@new_employee_attendance_edit")->name("new-employee-attendance-edit");
  Route::post("new-employee-attendance-update", "backend\EmployeeAttendence@new_employee_attendance_update")->name("new-employee-attendance-update");
  // account part
  Route::prefix('/accounting')->group(function(){
    Route::get('/report', 'ClientReportController@accountingReport')->name('accounting.report');
    Route::get('new-chart-of-account', 'backend\MasterAccountController@chart_of_account')->name('new-chart-of-account');
    Route::get('new-account-head', 'backend\MasterAccountController@new_account_head')->name('new-account-head');
    Route::get('/cost-center-details', 'backend\CostCenterController@costCenterDetails')->name('costCenterDetails');
    Route::get('/profit-details', 'backend\ProfitCenterController@ProfitCenterDetails')->name('profitCenterDetails');
    Route::get('/party-info', 'backend\PartyInfoController@partyInfoDetails')->name('partyInfoDetails');
    Route::resource('service-provider', 'backend\ServiceProviderController');
    Route::get('new-journal', 'backend\JournalEntryController@new_journal')->name('new-journal');
    Route::get("new-journal-creation", "backend\JournalEntryController@new_journal_creation")->name("new-journal-creation");
    Route::get('journal-authorization-section', 'backend\JournalEntryController@journal_authorization_section')->name('journal-authorization-section');
    Route::get("journal-approval-section", "backend\JournalEntryController@journal_approval_section")->name("journal-approval-section");
    Route::get('opening-asset', 'backend\OpeningBalanceController@opening_asset')->name('opening-asset');
    Route::get('opening-expence', 'backend\OpeningBalanceController@opening_expence')->name('opening-expence');
    Route::get('opening-inventory', 'backend\OpeningBalanceController@opening_inventory')->name('opening-inventory');
    Route::get('opening-cash-asset', 'backend\OpeningBalanceController@opening_cash_asset')->name('opening-cash-asset');
    Route::get('opening-reciavable-payable', 'backend\OpeningBalanceController@opening_reciavable_payable')->name('opening-reciavable-payable');
    Route::get('opening-others', 'backend\OpeningBalanceController@opening_others')->name('opening-others');
    Route::get("new-donar", "backend\DonarController@new_donar")->name("new-donar");
    Route::get("new-charity", "backend\DonarController@new_charity")->name("new-charity");
    Route::post("charitystore", "backend\DonarController@charitystore")->name("charitystore");
    Route::get('journal-success/{id}', 'backend\JournalEntryController@journal_success')->name('journal-success');

    //purchase expense
    Route::get('purchase-expense-list', 'backend\purchaseExpenseController@purchase_expense_list')->name('purchase-expense-list');
    Route::post('party-ledger-modal', 'backend\AccountsReportController@party_report_modal')->name('party-ledger-modal');
    Route::post('head-ledger-show', 'backend\AccountsReportController@head_ledger_show')->name('head-ledger-show');
    Route::post('master-ledger-show', 'backend\AccountsReportController@master_head_ledger')->name('master-head-ledger');
    Route::get('purchase-expense-invoice', 'backend\purchaseExpenseController@purchase_expense_invoice')->name('purchase-expense-invoice');
    Route::get('purchase-expense-bill', 'backend\purchaseExpenseController@purchase_expense_bill')->name('purchase-expense-bill');
    Route::get('purchase-expense-garage', 'backend\purchaseExpenseController@purchase_expense')->name('purchase-expense');
    Route::get('purchase-expense-office', 'backend\purchaseExpenseController@purchase_expense_office')->name('purchase-expense-office');
    Route::get('purchase-expense/edit/{id}', 'backend\purchaseExpenseController@purchase_expense_edit')->name('purchase-expense.edit');
    Route::post('purchase-expense/edit/post/{id}', 'backend\purchaseExpenseController@expense_edit_post')->name('expense-edit-post');
    Route::resource('expense-distribution','ExpenceDistrybutionController');

    Route::get('bill-list', 'backend\purchaseExpenseController@bill_list')->name('bill-list');
    Route::get('garage-list/{type}', 'backend\purchaseExpenseController@garage_list')->name('garage-list');
    Route::post('expensepost/post', 'backend\purchaseExpenseController@expensepost')->name('expensepost');
    Route::post('expensepost-bill/post', 'backend\purchaseExpenseController@expensepost_bill')->name('expensepost-bill');

    Route::resource('sale/revenues', 'backend\SaleRevenueController')->names('sale.revenues');
    Route::get('sale/approve_show/{id}', 'backend\SaleRevenueController@approve_show')->name('sale.approve_show');
    Route::get('sale/revenues/approve/list', 'backend\SaleRevenueController@approveList')->name('sale.revenues.approve');
    Route::get('sale/revenues/approval/{id}', 'backend\SaleRevenueController@approval')->name('sale.revenues.approval');

    Route::post('check-account-head', 'backend\JournalEntryController@check_account_head')->name('check-account-head');
    Route::post('invoice_no_validation', 'backend\purchaseExpenseController@invoice_no_validation')->name('invoice_no_validation');
    Route::post('find-tax_rate', 'backend\JournalEntryController@findTaxRate')->name('findTaxRate');
    Route::post('find-project', 'backend\JournalEntryController@findProject')->name('findProject');
    Route::post('find-cost-center', 'backend\JournalEntryController@findCostCenter')->name('findCostCenter');
    Route::post('partyInfoInvoice2R', 'backend\purchaseExpenseController@partyInfoInvoice2')->name('partyInfoInvoice2R');
    Route::post('party/info/by/term2/', 'backend\JournalEntryController@partyInfoInvoice2')->name('partyInfoInvoice2');
    Route::post('party/info/by/term3/', 'backend\JournalEntryController@partyInfoInvoice3')->name('partyInfoInvoice3');
    Route::post('find-account-head', 'backend\JournalEntryController@findAccHead')->name('findAccHead');
    Route::post('find-account-head/id', 'backend\JournalEntryController@findAccHeadId')->name('findAccHeadId');
    Route::post('receipt-post', 'backend\purchaseExpenseController@receipt_post')->name('receipt-post');
    Route::post('findsaleRec', 'backend\purchaseExpenseController@findsaleRec')->name('findsaleRec');
    Route::post('search-purchase-expense', 'backend\purchaseExpenseController@search_purch')->name('search-purchase-expense');
    Route::get('purchase-authorize', 'backend\purchaseExpenseController@purchase_authorize')->name('purchase_authorize');
    Route::get('purchase-authorize/{id}', 'backend\purchaseExpenseController@purchase_authorization')->name('purchase-authorize');
    Route::get('purchase-approve-bill/{type}', 'backend\purchaseExpenseController@purchase_approve')->name('purchase_approve');
    Route::get('purchase-approve-bill', 'backend\purchaseExpenseController@purchase_approve_bill')->name('purchase_approve_bill');
    Route::get('purchase-approval-bill/{id}', 'backend\purchaseExpenseController@purchase_approval')->name('purchase-approve');

    Route::get('purchase-approval/{id}', 'backend\purchaseExpenseController@purchase_approval')->name('purchase-approval');
    Route::get('payment-realised/{id}', 'backend\purchaseExpenseController@payment_realised')->name('payment-realised');
    Route::get('payment-declined/{id}', 'backend\purchaseExpenseController@payment_declined')->name('payment-declined');
    Route::post('payment-nex-deposit/{id}', 'backend\purchaseExpenseController@payment_deposit')->name('nex-deposit');
    Route::get('purchase-expense-delete/{id}', 'backend\purchaseExpenseController@purchase_delete')->name('purchase-expense.delete');
    Route::post('temp-payment-voucher-store', 'backend\TempPaymentVoucherController@temp_payment_voucher_store')->name('temp-payment-voucher-store');
    Route::get('payment-voucher-authorize/{id}', 'backend\TempPaymentVoucherController@payment_voucher_authorize')->name('payment-voucher-authorize');
    Route::get('payment-voucher-approve/{id}', 'backend\TempPaymentVoucherController@payment_voucher_approve')->name('payment-voucher-approve');
    Route::get('temp-payment-voucher-authorize', 'backend\TempPaymentVoucherController@temp_payment_voucher_authorize')->name('temp-payment-voucher-authorize');
    Route::post('add-bill-number', 'backend\purchaseExpenseController@add_bill_number')->name('add-bill-number');
    Route::get('search-expense-amount', 'backend\purchaseExpenseController@search_expense_amount')->name('search-expense-amount');
    // accounting report
    Route::get('new-general-ledger', 'backend\AccountsReportController@new_general_ledger')->name('new-general-ledger');
    Route::get('party-report', 'backend\AccountsReportController@party_report')->name('party-report');
    Route::get('new-trial-balance', 'backend\AccountsReportController@new_trial_balance')->name('new-trial-balance');
    Route::get('income-statement', 'backend\AccountsReportController@income_statement')->name('income-statement');
    Route::get('daily-report', 'backend\AccountsReportController@daily_report')->name('daily-report');
    Route::get('head-details/{account_head_id}', 'backend\AccountsReportController@head_details')->name('head-details');
    Route::get('party-head-details/{party}-{account_head_id}', 'backend\AccountsReportController@party_head_details')->name('party-head-details');
    Route::get('sub-ledger/{master_account}', 'backend\AccountsReportController@sub_ledger')->name('sub-ledger');
    Route::get('balance-sheet', 'backend\AccountsReportController@balance_sheet')->name('balance-sheet');
    Route::get('sale-reports', 'backend\AccountsReportController@sale_reports')->name('sale-reports');
    Route::get('purchase-reports', 'backend\AccountsReportController@purchase_reports')->name('purchase-reports');
    Route::get('receivable-reports', 'backend\AccountsReportController@receivable_reports')->name('receivable-reports');
    Route::get('payable-reports', 'backend\AccountsReportController@payable_reports')->name('payable-reports');
    Route::get('vat-report', 'backend\AccountsReportController@vat_report')->name('vat-report');
    // daily reports
    Route::get('daily-summary', 'backend\AccountsReportController@daily_summary')->name('daily-summary.report');

    Route::post('cash-today-sale-received', 'backend\AccountsReportController@cash_today_sale_received')->name('cash-today-sale-received');
    Route::post('cash-today-payment-expense', 'backend\AccountsReportController@cash_today_payment_expense')->name('cash-today-payment-expense');
    Route::post('cash-previous-receivable-receive', 'backend\AccountsReportController@cash_previous_receivable_receive')->name('cash-previous-receivable-receive');
    Route::post('cash-previous-payable-payment', 'backend\AccountsReportController@cash_previous_payable_payment')->name('cash-previous-payable-payment');
    Route::post('cash-advance-receive', 'backend\AccountsReportController@cash_advance_receive')->name('cash-advance-receive');
    Route::post('cash-advance-payment', 'backend\AccountsReportController@cash_advance_payment')->name('cash-advance-payment');

    Route::post('bank-today-sale-received', 'backend\AccountsReportController@bank_today_sale_received')->name('bank-today-sale-received');
    Route::post('bank-today-payment-expense', 'backend\AccountsReportController@bank_today_payment_expense')->name('bank-today-payment-expense');
    Route::post('bank-previous-receivable-receive', 'backend\AccountsReportController@bank_previous_receivable_receive')->name('bank-previous-receivable-receive');
    Route::post('bank-previous-payable-payment', 'backend\AccountsReportController@bank_previous_payable_payment')->name('bank-previous-payable-payment');
    Route::post('bank-advance-receive', 'backend\AccountsReportController@bank_advance_receive')->name('bank-advance-receive');
    Route::post('bank-advance-payment', 'backend\AccountsReportController@bank_advance_payment')->name('bank-advance-payment');

    Route::post('previous-account-receivable', 'backend\AccountsReportController@previous_account_receivable')->name('previous-account-receivable');
    Route::post('today-account-receivable', 'backend\AccountsReportController@today_account_receivable')->name('today-account-receivable');

    Route::post('previous-account-payable', 'backend\AccountsReportController@previous_account_payable')->name('previous-account-payable');
    Route::post('today-account-payable', 'backend\AccountsReportController@today_account_payable')->name('today-account-payable');
    Route::post('fund-transfer/{from}/{to}', 'backend\AccountsReportController@fund_transfer')->name('fund-transfer');

    Route::post('today-payment-expense/{pay_mode}', 'backend\AccountsReportController@today_payment_expense')->name('today-payment-expense');
    Route::post('previous-payment-expense/{pay_mode}', 'backend\AccountsReportController@previous_payment_expense')->name('previous-payment-expense');
    // fund allocation
    Route::resource('fund-allocation', 'backend\FundAllocationController');
    Route::get('fund-allocation-approval/{id}', 'backend\FundAllocationController@fund_allocation_approval')->name('fund-allocation-approval');
    Route::get('fund-allocation-approve', 'backend\FundAllocationController@fund_allocation_approve')->name('fund-allocation-approve');
    Route::get('allocation-print/{id}', 'backend\FundAllocationController@allocation_print')->name('allocation-print');
    Route::get('fund-allocation-delete/{id}', 'backend\FundAllocationController@fund_allocation_delete')->name('fund-allocation-delete');
    Route::post('fund-allocation-edit', 'backend\FundAllocationController@fund_allocation_edit')->name('fund-allocation-edit');
    Route::post('multiple-approval-fund-allocation', 'backend\FundAllocationController@multiple_approval_fund_allocation')->name('multiple-approval-fund-allocation');
    Route::get('petty-cash-report', 'backend\AccountsReportController@petty_cash_report')->name('petty-cash-report');
    Route::get('cash-counter-report', 'backend\CashCounterController@cash_counter_report')->name('cash-counter-report');
    Route::get('cash-counter-paid-tally/{id}', 'backend\CashCounterController@cash_counter_paid_tally')->name('cash-counter-paid-tally');
    Route::post('cash-counter-show', 'backend\CashCounterController@cash_counter_show')->name('cash-counter-show');
    // receipt voucher
    Route::get('receipt-voucher3', 'backend\SaleController@receipt_voucher3')->name('receipt-voucher3');
    Route::get('receipt-voucher-edit/{id}', 'backend\TempReceiptVoucherController@receipt_voucher_edit')->name('receipt-voucher-edit');
    Route::get('temp-receipt-voucher-authorize', 'backend\TempReceiptVoucherController@temp_receipt_voucher_authorize')->name('temp-receipt-voucher-authorize');
    Route::get('temp-receipt-voucher-approve', 'backend\TempReceiptVoucherController@temp_receipt_voucher_approve')->name('temp-receipt-voucher-approve');
    Route::get('receipt-voucher2', 'backend\SaleController@receipt_voucher2')->name('receipt-voucher2');
    Route::get('receipt-voucher-list-show', 'backend\SaleController@receipt_voucher_list_show')->name('receipt-voucher-list-show');
    Route::post('search-sale', 'backend\SaleController@search_sale')->name('search-sale');
    Route::post('payment-post', 'backend\SaleController@payment_post')->name('payment-post');
    Route::post('partyInfosale2R', 'backend\SaleController@partyInfosale2')->name('partyInfosale2R');
    Route::post('search-receipt', 'backend\SaleController@search_receipt')->name('search-receipt');
    Route::post('find-job-project', 'backend\SaleController@find_job_project')->name('find-job-project');
    Route::get('receipt-realised/{id}', 'backend\SaleController@receipt_realised')->name('receipt-realised');
    Route::get('receipt-declined/{id}', 'backend\SaleController@receipt_declined')->name('receipt-declined');
    Route::post('receipt-nex-deposit/{id}', 'backend\SaleController@receipt_deposit')->name('nex-deposit-receipt');
    Route::post('search-sale-inv', 'backend\SaleController@search_sale_inv')->name('search-sale-inv');
    Route::post('search-sale', 'backend\SaleController@search_sale')->name('search-sale');
    Route::get('receivable', 'backend\SaleController@receivable')->name('receivable');
    Route::post('search-customer-due', 'backend\SaleController@search_customer_due')->name('search-customer-due');
    // payment voucher
    Route::get('purchase-expense-invoice', 'backend\purchaseExpenseController@purchase_expense_invoice')->name('purchase-expense-invoice');
    Route::get('purchase_expense_edit/{id}', 'backend\purchaseExpenseController@purchase_expense_edit')->name('purchase-expense.edit');
    Route::post('purchase-expense/edit/post/{id}', 'backend\purchaseExpenseController@expense_edit_post')->name('expense-edit-post');
    Route::get('payment-voucher2', 'backend\purchaseExpenseController@payment_voucher2')->name('payment-voucher2');
    Route::get('payment-voucher2-list', 'backend\purchaseExpenseController@payment_voucher2_list')->name('payment-voucher2-list');
    Route::post('expensepost/post', 'backend\purchaseExpenseController@expensepost')->name('expensepost');
    Route::post('check-account-head', 'backend\JournalEntryController@check_account_head')->name('check-account-head');
    Route::post('invoice_no_validation', 'backend\purchaseExpenseController@invoice_no_validation')->name('invoice_no_validation');
    Route::post('find-tax_rate', 'backend\JournalEntryController@findTaxRate')->name('findTaxRate');
    Route::post('find-project', 'backend\JournalEntryController@findProject')->name('findProject');
    Route::post('find-cost-center', 'backend\JournalEntryController@findCostCenter')->name('findCostCenter');
    Route::post('partyInfoInvoice2R', 'backend\purchaseExpenseController@partyInfoInvoice2')->name('partyInfoInvoice2R');
    Route::post('party/info/by/term2/', 'backend\JournalEntryController@partyInfoInvoice2')->name('partyInfoInvoice2');
    Route::post('party/info/by/term3/', 'backend\JournalEntryController@partyInfoInvoice3')->name('partyInfoInvoice3');
    Route::post('find-account-head', 'backend\JournalEntryController@findAccHead')->name('findAccHead');
    Route::post('find-account-head/id', 'backend\JournalEntryController@findAccHeadId')->name('findAccHeadId');
    Route::post('receipt-post', 'backend\purchaseExpenseController@receipt_post')->name('receipt-post');
    Route::post('findsaleRec', 'backend\purchaseExpenseController@findsaleRec')->name('findsaleRec');
    Route::post('search-purchase-expense', 'backend\purchaseExpenseController@search_purch')->name('search-purchase-expense');
    Route::get('purchase-authorize', 'backend\purchaseExpenseController@purchase_authorize')->name('purchase_authorize');
    Route::get('purchase-authorize/{id}', 'backend\purchaseExpenseController@purchase_authorization')->name('purchase-authorize');
    Route::get('payment-realised/{id}', 'backend\purchaseExpenseController@payment_realised')->name('payment-realised');
    Route::get('payment-declined/{id}', 'backend\purchaseExpenseController@payment_declined')->name('payment-declined');
    Route::post('payment-nex-deposit/{id}', 'backend\purchaseExpenseController@payment_deposit')->name('nex-deposit');
    Route::get('purchase-expense-delete/{id}', 'backend\purchaseExpenseController@purchase_delete')->name('purchase-expense.delete');
    //
    Route::post('temp-payment-voucher-store', 'backend\TempPaymentVoucherController@temp_payment_voucher_store')->name('temp-payment-voucher-store');
    Route::get('payment-voucher-authorize/{id}', 'backend\TempPaymentVoucherController@payment_voucher_authorize')->name('payment-voucher-authorize');
    Route::get('payment-voucher-approve/{id}', 'backend\TempPaymentVoucherController@payment_voucher_approve')->name('payment-voucher-approve');
    Route::get('temp-payment-voucher-authorize', 'backend\TempPaymentVoucherController@temp_payment_voucher_authorize')->name('temp-payment-voucher-authorize');
    Route::get('temp-payment-voucher-approve', 'backend\TempPaymentVoucherController@temp_payment_voucher_approve')->name('temp-payment-voucher-approve');
    Route::get('temp-payment-voucher-edit/{id}', 'backend\TempPaymentVoucherController@temp_payment_voucher_edit')->name('temp-payment-voucher-edit');
    Route::post('temp-payment-voucher-update', 'backend\TempPaymentVoucherController@temp_payment_voucher_update')->name('temp-payment-voucher-update');
    Route::get('temp-payment-voucher-delete/{id}', 'backend\TempPaymentVoucherController@temp_payment_voucher_delete')->name('temp-payment-voucher-delete');
    Route::get('payable', 'backend\purchaseExpenseController@payable')->name('payable');
    Route::post('search-supplier-due', 'backend\purchaseExpenseController@search_supplier_due')->name('search-supplier-due');

  });

  Route::post('check-invoice-no', 'backend\CustomerInvoiceController@check_invoice_no')->name('check-invoice-no');
  Route::prefix('/business-operation')->group(function(){
    Route::get('/report', 'ClientReportController@business_operation')->name('business-operation.report');
    Route::get('customer-invoice', 'backend\CustomerInvoiceController@customer_invoice')->name('customer-invoice');
    Route::get('draft-invoice-list', 'backend\CustomerInvoiceController@draft_invoice_list')->name('draft-invoice-list');
    Route::get('customer-invoice-edit/{id}', 'backend\CustomerInvoiceController@customer_invoice_edit')->name('customer-invoice-edit');
    Route::get('invoice-athurization-list', 'backend\CustomerInvoiceController@invoice_athurization_list')->name('invoice-athurization-list');
    Route::get('invoice-approval-list', 'backend\CustomerInvoiceController@invoice_approval_list')->name('invoice-approval-list');
    Route::get('approved-invoice-list', 'backend\CustomerInvoiceController@approved_invoice_list')->name('approved-invoice-list');
    Route::get('declined-invoice-list', 'backend\CustomerInvoiceController@declined_invoice_list')->name('declined-invoice-list');
    Route::get('search-customer-invoice', 'backend\CustomerInvoiceController@search_customer_invoice')->name('search-customer-invoice');
    Route::get('pre-invoice-view/{id}', 'backend\CustomerInvoiceController@temp_invoice_view')->name('temp-invoice-view');
    Route::get('temp-invoice-sumview/{id}', 'backend\CustomerInvoiceController@temp_invoice_sumview')->name('temp-invoice-sumview');
    Route::get('invoice-summery-view/{id}', 'backend\CustomerInvoiceController@invoice_sumview')->name('invoice-sumview');
    Route::get('invoice-view/{id}', 'backend\CustomerInvoiceController@invoice_view')->name('invoice-view');
    Route::get('draft-invoice-edit/{id}', 'backend\CustomerInvoiceController@draft_invoice_edit')->name('draft-invoice-edit');
    Route::get('draft-invoice-preview/{id}', 'backend\CustomerInvoiceController@draft_invoice_preview')->name('draft-invoice-preview');
    Route::resource('temp-toll-invoice-view', 'backend\TollFeeInvoiceTempController');
    Route::get('toll-fee-invoice-sumview/{id}', 'backend\TollFeeInvoiceController@toll_fee_invoice_sumview')->name('toll-fee-invoice-sumview');
    // supplier invoice
    Route::get('supplier', 'backend\SupplierInvoiceController@supplier_invoice')->name('supplier-invoice');
    Route::get('supplier-invoice-list', 'backend\SupplierInvoiceController@supplier_invoice_list')->name('supplier-invoice-list');
    Route::get('authorize-supplier-invoice', 'backend\SupplierInvoiceController@authorize_supplier_invoice_list')->name('authorize-supplier-invoice');
    Route::get('approval-supplier-invoice', 'backend\SupplierInvoiceController@approval_supplier_invoice_list')->name('approval-supplier-invoice');
    Route::get('declined-supplier-invoice', 'backend\SupplierInvoiceController@declined_supplier_invoice_list')->name('declined-supplier-invoice');
    Route::get('delete-supplier-inv/{id}', 'backend\SupplierInvoiceController@delete_invoice')->name('delete-supplier-inv');
    // supplier draft
    Route::get('supplier-draft-invoice-list', 'backend\SupplierInvoiceController@supplier_draft_invoice_list')->name('supplier-draft-invoice-list');
    Route::get('draft-pre-supplier-invoice-view/{id}', 'backend\SupplierInvoiceController@draft_supplier_invoice_view')->name('draft-pre-supplier-invoice-view');
    Route::get('submit-draft-supplier-invoice/{id}', 'backend\SupplierInvoiceController@submit_draft_supplier_invoice')->name('submit-draft-supplier-invoice');
    Route::get('pre-supplier-invoice-view/{id}', 'backend\SupplierInvoiceController@pre_supplier_invoice_view')->name('pre-supplier-invoice-view');
    Route::get('pre-authorize-supplier-invoice/{id}', 'backend\SupplierInvoiceController@pre_authorize_supplier_invoice')->name('pre-authorize-supplier-invoice');
    Route::get('pre-decline-supplier-invoice/{id}', 'backend\SupplierInvoiceController@pre_decline_supplier_invoice')->name('pre-decline-supplier-invoice');
    Route::get('supplier-invoice-process', 'backend\SupplierInvoiceController@supplier_invoice_process')->name('supplier-invoice_process');
    Route::POST('supplier-invoice-save', 'backend\SupplierInvoiceController@save_supplier_invoice')->name('save-supplier-invoice');
    Route::get('supplier-invoice-view/{id}', 'backend\SupplierInvoiceController@supplier_invoice_view')->name('supplier-invoice-view');
    Route::get('supplier-invoice-summery-view/{id}', 'backend\SupplierInvoiceController@supplier_invoice_sumview')->name('supplier-invoice-sumview');
    Route::get('supplier-invoice-print/{id}', 'backend\SupplierInvoiceController@supplier_invoice_print')->name('supplier-invoice-print');
    Route::get('supplier-invoice-sum-print/{id}', 'backend\SupplierInvoiceController@supplier_invoice_sum_print')->name('supplier-invoice-sum-print');

    Route::resource('toll-fees-recharge', 'backend\TollFeesRechargeController');
    Route::post('toll-fees-view-modal', 'backend\TollFeesRechargeController@toll_fees_view_modal')->name('toll-fees-view-modal');
    Route::resource('toll-fees-payment', 'backend\TollFeesPaymentController');
    Route::post('toll-fees-payment-view-modal', 'backend\TollFeesPaymentController@toll_fees_payment_view_modal')->name('toll-fees-payment-view-modal');

    // sale revenue
  });

  Route::prefix('/service-inventory')->group(function(){
    // token
    Route::get('report', 'ClientReportController@service_inventory')->name('service-inventory.report');
    Route::resource('token-gereration', 'backend\TokenGenerationController');
    Route::resource('vehicle-expense', 'backend\VehicleExpenseController');
    Route::post('vehicle-expense-view-modal', 'backend\VehicleExpenseController@vehicle_expense_view_modal')->name('vehicle-expense-view-modal');

    Route::get('item-expense', 'backend\VehicleExpenseController@item_expense')->name('item-expense');
    Route::post('item-expense-store', 'backend\VehicleExpenseController@item_expense_store')->name('item-expense-store');

    Route::resource('product', 'backend\ProductController');
    Route::resource('category', 'backend\CategoryController');
    Route::resource('brand', 'backend\BrandController');
  });
  Route::post('head-store', 'backend\purchaseExpenseController@head_store')->name('head-store');
  Route::get('brand-delete/{id}', 'backend\BrandController@delete')->name('brand.delete');
  Route::get('sub-brand-delete/{id}', 'backend\SubBrandController@delete')->name('subBrand.delete');
  Route::post('brand.fetch', 'backend\ProductController@brand_fatch')->name('brand.fetch');
  Route::post('sub_brand.fetch', 'backend\ProductController@subBrand_fatch')->name('sub_brand.fetch');
  Route::post('available-pay-amount', 'backend\purchaseExpenseController@available_pay_amount')->name('available-pay-amount');

  Route::resource('account-info','CurrencyController');
  Route::post('expensepost/post', 'backend\purchaseExpenseController@expensepost')->name('expensepost');
  Route::post('purch-exp-modal', 'backend\purchaseExpenseController@purch_exp_modal')->name('purch-exp-modal');
  Route::post('payment-modal', 'backend\purchaseExpenseController@payment_modal')->name('payment-modal');
  Route::get('purchase-expense-invoice', 'backend\purchaseExpenseController@purchase_expense_invoice')->name('purchase-expense-invoice');
  Route::post('find-invoice', 'backend\purchaseExpenseController@find_invoice')->name('find-invoice');
  Route::post('find-invoice-date', 'backend\purchaseExpenseController@find_invoice_date')->name('find-invoice-date');
  Route::post('findinvoiceRec', 'backend\purchaseExpenseController@findinvoiceRec')->name('findinvoiceRec');
  Route::post('invoice_no_validation', 'backend\purchaseExpenseController@invoice_no_validation')->name('invoice_no_validation');
  Route::post('sale_no_validation', 'backend\SaleRevenueController@sale_no_validation')->name('sale_no_validation');

  Route::post('receipt-post', 'backend\purchaseExpenseController@receipt_post')->name('receipt-post');
  Route::get('saleIssue', 'backend\purchaseExpenseController@saleIssue')->name('saleIssue');
  Route::post('saleIssue/post', 'backend\purchaseExpenseController@saleIssuepost')->name('saleIssuepost');
  Route::get('sale-list', 'backend\purchaseExpenseController@sale_list')->name('sale-list');
  Route::post('sale-modal', 'backend\purchaseExpenseController@sale_modal')->name('sale-modal');
  Route::post('receipt-list-modal', 'backend\TempReceiptVoucherController@receipt_voucher_preview')->name('receipt-list-modal');

  Route::post('partyInfosale2R', 'backend\purchaseExpenseController@partyInfosale2')->name('partyInfosale2R');
  Route::post('findsaleRec', 'backend\purchaseExpenseController@findsaleRec')->name('findsaleRec');
  Route::post('payment-post', 'backend\purchaseExpenseController@payment_post')->name('payment-post');
  Route::post('transection-heads', 'backend\JournalEntryController@transection_heads')->name('transection-heads');
  Route::resource('asset', 'backend\AssetController');
  Route::post('opening-asset-store', 'backend\OpeningBalanceController@opening_asset_store')->name('opening-asset.store');

  Route::post('temp-receipt-voucher-preview', 'backend\TempReceiptVoucherController@temp_receipt_voucher_preview')->name('temp-receipt-voucher-preview');
  Route::post('receivable-view', 'backend\SaleController@receivable_view')->name('receivable-view');
  Route::prefix('/receipt')->group(function(){
    Route::get('/report', 'ClientReportController@receiptReport')->name('receipt.report');

  });

  Route::prefix('/sales')->group(function(){
    Route::get('/report', 'ClientReportController@salesReport')->name('sales.report');
    Route::get('saleIssue', 'backend\SaleController@saleIssue')->name('saleIssue');
    Route::get('sale-list', 'backend\SaleController@sale_list')->name('sale-list');
    Route::post('search-all-invoice-list', 'backend\SaleController@search_all_invoice_list')->name('search-all-invoice-list');
    Route::get('all-invoice-list', 'backend\SaleController@all_invoice_list')->name('all-invoice-list');
    Route::get('sale-direct-invoice-list', 'backend\SaleController@sale_list_direct')->name('sale-direct-invoice-list');
    Route::get('sale-proforma-invoice-list', 'backend\SaleController@sale_list_proforma')->name('sale-proforma-invoice-list');



    Route::post('saleIssue/post', 'backend\SaleController@saleIssuepost')->name('saleIssuepost');
    Route::post('search-sale', 'backend\SaleController@search_sale')->name('search-sale');
    Route::post('payment-post', 'backend\SaleController@payment_post')->name('payment-post');
    Route::post('partyInfosale2R', 'backend\SaleController@partyInfosale2')->name('partyInfosale2R');
    Route::post('partyInfodueInvoices', 'backend\SaleController@partyInfodueInvoices')->name('partyInfodueInvoices');
    Route::post('findInvoiceforReceipt', 'backend\SaleController@findInvoiceforReceipt')->name('findInvoiceforReceipt');

    Route::post('search-receipt', 'backend\SaleController@search_receipt')->name('search-receipt');
    Route::post('find-job-project', 'backend\SaleController@find_job_project')->name('find-job-project');
    Route::get('receipt-realised/{id}', 'backend\SaleController@receipt_realised')->name('receipt-realised');
    Route::get('receipt-declined/{id}', 'backend\SaleController@receipt_declined')->name('receipt-declined');
    Route::post('receipt-nex-deposit/{id}', 'backend\SaleController@receipt_deposit')->name('nex-deposit-receipt');
    Route::get('sale-authorize', 'backend\SaleController@sale_authorize')->name('sale_authorize');
    Route::get('sale-approve', 'backend\SaleController@sale_approve')->name('sale_approve');
    Route::get('sale-authorize/{id}', 'backend\SaleController@sale_authorization')->name('sale-authorize');
    Route::get('sale-approve/{id}', 'backend\SaleController@sale_approval')->name('sale-approve');
    Route::get('sale-delete/{id}', 'backend\SaleController@sale_delete')->name('sale.delete');
    ///////
    Route::post('temp-receipt-voucher-post', 'backend\TempReceiptVoucherController@store')->name('temp-receipt-voucher-post');
    Route::post('temp-receipt-voucher-post-inv', 'backend\TempReceiptVoucherController@store_invoice_receipt')->name('temp-receipt-voucher-post-inv');

    Route::post('search-receipt-voucher-temp', 'backend\TempReceiptVoucherController@search_receipt')->name('search-receipt-voucher-temp');
    Route::get('receipt-voucher-approve/{id}', 'backend\TempReceiptVoucherController@receipt_voucher_approve')->name('receipt-voucher-approve');
    Route::post('temp-receipt-voucher-update', 'backend\TempReceiptVoucherController@temp_receipt_voucher_update')->name('temp-receipt-voucher-update');
    Route::get('receipt-voucher-delete/{id}', 'backend\TempReceiptVoucherController@temp_receipt_delete')->name('receipt-voucher-delete');
    Route::get('direct-receipt', 'backend\TempReceiptVoucherController@direct_receipt')->name('direct-receipt');
    Route::post('direct-receipt-post', 'backend\TempReceiptVoucherController@direct_receipt_post')->name('direct-receipt-post');
    Route::post('/saleIssu/update','backend\SaleController@saleIssueEdit')->name('saleIssuepost.edit');
    Route::get('proforma-invoice-edit/{id}', 'backend\SaleController@proforma_edit')->name('proforma-invoice-edit');
    Route::get('transection', 'backend\SaleController@transection')->name('transection');
    Route::post('search-all-transection-list', 'backend\SaleController@search_all_transection_list')->name('search-all-transection-list');

  });
  //purchase start
  Route::prefix('/payment')->group(function(){
    Route::get('/payment-report', 'ClientReportController@paymentReport')->name('payment-report');

  });
  Route::post('payable-view', 'backend\purchaseExpenseController@payable_view')->name('payable-view');

  Route::post('find-invoice', 'backend\purchaseExpenseController@find_invoice')->name('find-invoice');
  Route::post('find-invoice-date', 'backend\purchaseExpenseController@find_invoice_date')->name('find-invoice-date');
  Route::post('purch-exp-modal', 'backend\purchaseExpenseController@purch_exp_modal')->name('purch-exp-modal');
  Route::post('auth-purch-exp-modal', 'backend\purchaseExpenseController@auth_purch_exp_modal')->name('auth_purch-exp-modal');
  Route::post('approve-purch-exp-modal', 'backend\purchaseExpenseController@approve_purch_exp_modal')->name('approve_purch-exp-modal');
  Route::post('payment-modal', 'backend\purchaseExpenseController@payment_modal')->name('payment-modal');
  //
  Route::post('temp-payment-voucher-preview', 'backend\TempPaymentVoucherController@temp_payment_voucher_preview')->name('temp-payment-voucher-preview');

    Route::get('/get-header', function () {
      return view('layouts.backend.partial.modal-header-info')->render();
    });
    Route::get('/get-footer', function () {
        return view('layouts.backend.partial.modal-footer-info')->render();
    });
    Route::prefix('/business')->group(function(){
      Route::get('/business-report', 'ClientReportController@business')->name('business-report');


  });
  });
