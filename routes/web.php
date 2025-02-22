<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AssetListController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\EmployeeAssetController;
use App\Http\Controllers\Leave_typeController;
use App\Http\Controllers\Leave_applyController;
use App\Http\Controllers\Leave_earnController;
use App\Http\Controllers\LeaveViewController;
use App\Http\Controllers\LeaveReportController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\PerdeimController;
use App\Http\Controllers\PerdeimViewController;
use App\Http\Controllers\PerdeimRetireViewController;
use App\Http\Controllers\PerdeimretireController;
use App\Http\Controllers\PayrolController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\EmployeeDeductionController;
use App\Http\Controllers\EmployeeBenefitController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\WorkOverTimeController;
use App\Http\Controllers\FundRequestController;
use App\Http\Controllers\EmployeeTimesheetController;
use App\Http\Controllers\MachineTimesheetController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\CasualController;
use App\Http\Controllers\CasualDetailController;
use App\Http\Controllers\CasualPaymentDetailController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerInvoiceController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\ExpenditureCategoryController;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\BalanceSheetItemController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\PettyCashController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\PerformanceMetricController;
use App\Http\Controllers\TalentAcquisitionController;





/*
|--------------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index',])->name('home');

// user-managemnet route
Route::prefix('user-management')->group(function () {
    Route::resource('roles', 'App\Http\Controllers\RoleController', [
        'except' => ['show', 'create'],
    ]);
    Route::put('users/roles/{user}', [
        App\Http\Controllers\UserController::class,
        'updateRole',
    ])->name('users.roles.update');
    Route::resource('users', UserController::class);
});

Route::post('change-password', [App\Http\Controllers\UserController::class, 'changePassword',])->name('changePassword');

// organization routes
Route::resource('department', DepartmentController::class);
Route::resource('designation', DesignationController::class);
Route::resource('employee', EmployeeController::class);


// Asset routes
Route::resource('asset', AssetController::class);
Route::resource('assetlist', AssetListController::class);
Route::group(['prefix' => '/asset-list/{assetlist}', 'as' => 'assetlist.'], function () {
    Route::get('/depreciation-list', [AssetListController::class, 'viewDepreciation'])->name('view.depreciation');
    Route::get('/depreciation', [AssetListController::class, 'addDepreciation'])->name('add.depreciation');
    Route::get('/returned/{employee}', [EmployeeAssetController::class, 'returned'])->name('employee.returned');
    Route::resource('employeeAsset', EmployeeAssetController::class);
});

Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
Route::post('notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

Route::resource('leave_type', Leave_typeController::class);
Route::resource('leave_apply', Leave_applyController::class);
Route::resource('leave-report', LeaveReportController::class);
Route::resource('leave', Leave_applyController::class);
 Route::resource('employeeAsset', EmployeeAssetController::class);
 Route::post('/asset.assetSale', [EmployeeAssetController::class, 'assetSale'])->name('assetSale');
 Route::post('/asset.assetRetain', [EmployeeAssetController::class, 'assetRetain'])->name('assetRetain');
 Route::post('/asset.assetReturn', [EmployeeAssetController::class, 'assetReturn'])->name('assetReturn');
 Route::get('/assetCategoryDetails/{id}', [AssetController::class, 'assetCategoryDetails'])->name('assetCategoryDetails');

//leave Approval
Route::get('/leave.managerView', [App\Http\Controllers\Leave_applyController::class, 'managerView'])->name('leave.managerView');
Route::get('/leave.managerApprove/{id}', [App\Http\Controllers\Leave_applyController::class, 'managerApprove'])->name('leave.managerApprove');
Route::post('/leave.managerDecline', [App\Http\Controllers\Leave_applyController::class, 'managerDecline'])->name('leave.managerDecline');

Route::get('/leave.hrView', [App\Http\Controllers\Leave_applyController::class, 'hrView'])->name('leave.hrView');
Route::get('/leave.hrApprove/{id}', [App\Http\Controllers\Leave_applyController::class, 'hrApprove'])->name('leave.hrApprove');
Route::post('/leave.hrDecline', [App\Http\Controllers\Leave_applyController::class, 'hrDecline'])->name('leave.hrDecline');
Route::get('/leave/report', 'LeaveController@report')->name('leave.report');

Route::resource('holiday', HolidayController::class);
Route::resource('leave_earn', Leave_earnController::class);
Route::resource('perdeim', PerdeimController::class);

Route::resource('perdeim-employee', PerdeimViewController::class);
Route::resource('leave', Leave_applyController::class);

Route::resource('perdeimretire', PerdeimretireController::class);
Route::resource('perdeim-employee.perdeimretire-view', PerdeimRetireViewController::class);

//perdeimApproval
Route::get('/perdeim.managerView', [App\Http\Controllers\PerdeimController::class, 'managerView'])->name('perdeim.managerView');
Route::get('/perdeim.managerApprove/{id}', [App\Http\Controllers\PerdeimController::class, 'managerApprove'])->name('perdeim.managerApprove');
Route::post('/perdeim.managerDecline', [App\Http\Controllers\PerdeimController::class, 'managerDecline'])->name('perdeim.managerDecline');

Route::get('/perdeim.managerApproveRetirement/{id}', [App\Http\Controllers\PerdeimController::class, 'managerApproveRetirement'])->name('perdeim.managerApproveRetirement');
Route::post('/perdeim.managerDeclineRetirement', [App\Http\Controllers\PerdeimController::class, 'managerDeclineRetirement'])->name('perdeim.managerDeclineRetirement');

Route::get('/perdeim.drView', [App\Http\Controllers\PerdeimController::class, 'drView'])->name('perdeim.drView');
Route::get('/perdeim.drApprove/{id}', [App\Http\Controllers\PerdeimController::class, 'drApprove'])->name('perdeim.drApprove');
Route::get('/perdeim.drDecline', [App\Http\Controllers\PerdeimController::class, 'drDecline'])->name('perdeim.drDecline');
Route::get('/perdeim.drApproveRetirement/{id}', [App\Http\Controllers\PerdeimController::class, 'drApproveRetirement'])->name('perdeim.drApproveRetirement');
Route::post('/perdeim.drDeclineRetirement', [App\Http\Controllers\PerdeimController::class, 'drDeclineRetirement'])->name('perdeim.drDeclineRetirement');

Route::get('/perdeim.hrView', [App\Http\Controllers\PerdeimController::class, 'hrView'])->name('perdeim.hrView');
Route::get('/perdeim.hrApprove/{id}', [App\Http\Controllers\PerdeimController::class, 'hrApprove'])->name('perdeim.hrApprove');
Route::get('/perdeim.hrDecline/{id}', [App\Http\Controllers\PerdeimController::class, 'hrDecline'])->name('perdeim.hrDecline');
Route::get('/perdeim.perdeimretire.approve/{id}', [App\Http\Controllers\PerdeimretireController::class, 'approved'])->name('perdeim.perdeimretire.approve');
Route::get('/perdeim.perdeimretire.decline/{id}', [App\Http\Controllers\PerdeimretireController::class, 'declined'])->name('perdeim.perdeimretire.decline');
Route::resource('payrol', PayrolController::class);
Route::get('download-payslip/{id}', [App\Http\Controllers\PayrolController::class, 'generate_payslip'])->name('download.payslip');
Route::get('view-payslip/{id}', [App\Http\Controllers\PayrolController::class, 'view_payslip'])->name('payrol.payslip');
Route::get('monthlyEmployeePayrol/{month}', [App\Http\Controllers\PayrolController::class, 'monthlyEmployeePayroll'])->name('monthlyEmployeePayrol');
Route::get('myPayrol', [App\Http\Controllers\PayrolController::class, 'myPayroll'])->name('myPayrol');
//  Route::get('/payroll/monthly/{month}', 'PayrollController@monthlyEmployeePayroll')->name('monthlyEmployeePayroll');


Route::get('/payment', function () {
    return view('payrol.payslip.index');
});

Route::resource('deduction', DeductionController::class);
Route::resource('employee-deduction', EmployeeDeductionController::class);
Route::resource('employee-benefit', EmployeeBenefitController::class);
Route::resource('benefit', BenefitController::class);
Route::resource('salary', SalaryController::class);
Route::get('file.proof/{id}/download', [App\Http\Controllers\WorkOverTimeController::class, 'download'])->name('work.download');
Route::get('/work-overtime.approve/{id}', [App\Http\Controllers\WorkOverTimeController::class, 'approve'])->name('work-overtime.approve');
Route::get('/work-overtime.decline/{id}', [App\Http\Controllers\WorkOverTimeController::class, 'decline'])->name('work-overtime.decline');
Route::resource('work-overtime', WorkOverTimeController::class);
Route::get('download-contract/{id}', [App\Http\Controllers\EmployeeController::class, 'downloadContract'])->name('downloadContract');

Route::resource('fundRequest', FundRequestController::class);
Route::get('/fundrequest.managerView', [App\Http\Controllers\FundRequestController::class, 'managerView'])->name('fundrequest.managerView');
Route::get('/fundrequest.managerApprove/{id}', [App\Http\Controllers\FundRequestController::class, 'managerApprove'])->name('fundrequest.managerApprove');
Route::get('/fundrequest.managerDecline/{id}', [App\Http\Controllers\FundRequestController::class, 'managerDecline'])->name('fundrequest.managerDecline');

Route::get('/fundrequest.drView', [App\Http\Controllers\FundRequestController::class, 'drView'])->name('fundrequest.drView');
Route::get('/fundrequest.drApprove/{id}', [App\Http\Controllers\FundRequestController::class, 'drApprove'])->name('fundrequest.drApprove');
Route::get('/fundrequest.drDecline/{id}', [App\Http\Controllers\FundRequestController::class, 'drDecline'])->name('fundrequest.drDecline');
Route::get('fundRequest-destroyFundRequestItem/{id}', [FundRequestController::class, 'destroyFundRequestItem'])->name('destroyFundRequestItem');
Route::get('work-overtime-approveWorkOvertime', [WorkOverTimeController::class, 'approveWorkOvertime'])->name('approveWorkOvertime');
Route::get('download-payslip/{id}',[PayrolController::class, 'generate_payslip'])->name('generate_payslip');
Route::get('proof/{id}/download', [Leave_applyController::class, 'downloadProof',])->name('proof.download');
Route::get('file/{id}/download', [App\Http\Controllers\PerdeimretireController::class, 'download'])->name('retire.download');
Route::post('editUserPassword',[UserController::class, 'editUserPassword'])->name('editUserPassword');
Route::post('updateProfile',[UserController::class, 'updateProfile'])->name('updateProfile');
Route::get('/hrView', [App\Http\Controllers\FundRequestController::class, 'hrView'])->name('hrView');
Route::resource('employeeTimesheet', EmployeeTimesheetController::class);
Route::resource('machineTimesheet', MachineTimesheetController::class);
Route::resource('machine', MachineController::class);


Route::resource('casual',CasualController::class);
Route::resource('casualDetails', CasualDetailController::class);
Route::resource('casualPaymentDetails', CasualPaymentDetailController::class);
Route::get('/viewCasual/{id}',[App\Http\Controllers\CasualDetailController::class, 'viewCasual'])->name('viewCasual');

Route::resource('invoices',InvoiceController::class);
Route::resource('invoice', CustomerInvoiceController::class);

Route::get('download-invoice/{id}',[CustomerInvoiceController::class, 'invoice_generate'])->name('invoice_generate');
Route::post('update-paystatus',[CustomerInvoiceController::class, 'paid'])->name('paid');
Route::resource('income', IncomeController::class);
Route::resource('incomeCategory', IncomeCategoryController::class);
Route::resource('expenditure', ExpenditureController::class);
Route::resource('expenditureCategory', ExpenditureCategoryController::class);
Route::post('profitLossReport',[IncomeController::class, 'profitLossReport'])->name('profitLossReport');
Route::post('profitLoss',[IncomeController::class, 'profitLoss'])->name('profitLoss');
Route::get('profitNLoss',[IncomeController::class, 'profitNLoss'])->name('profitNLoss');

Route::resource('balanceSheet', BalanceSheetController::class);
Route::resource('balanceSheetItems', BalanceSheetItemController::class);
Route::get('balancesheetreport',[BalanceSheetController::class, 'balancesheetreport'])->name('balancesheetreport');
Route::resource('bank', BankController::class);
Route::get('bankIn/{id}',[BankController::class, 'bankIn'])->name('bankIn');
Route::get('bankOut/{id}',[BankController::class, 'bankOut'])->name('bankOut');
Route::put('bankOutUpdate/{id}',[BankController::class, 'bankOutUpdate'])->name('bankOutUpdate');
Route::put('bankInUpdate/{id}',[BankController::class, 'bankInUpdate'])->name('bankInUpdate');
Route::delete('bankInDelete/{id}',[BankController::class, 'bankInDelete'])->name('bankInDelete');
Route::delete('bankOutDelete/{id}',[BankController::class, 'bankOutDelete'])->name('bankOutDelete');
Route::post('bankInStore',[BankController::class, 'bankInStore'])->name('bankInStore');
Route::post('bankOutStore',[BankController::class, 'bankOutStore'])->name('bankOutStore');


Route::resource('cash', CashController::class);
Route::resource('pettyCash', PettyCashController::class);


Route::resource('performance', PerformanceMetricController::class);
Route::resource('talent', TalentAcquisitionController::class);



