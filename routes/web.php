<?php

use App\Http\Controllers\BhuBharatiController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\OutwardRegisterController;
use App\Http\Controllers\PostingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingPeriodController;
use App\Http\Controllers\PendingTappasController;
use App\Http\Controllers\GpoCertificateController;
use Google\Service\Dfareporting\Order;
use Illuminate\Support\Facades\Route;
use App\Models\Task;
use App\Http\Controllers\SurveyDetailController;
use App\Http\Controllers\SurrenderLeaveController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\CourtCaseController;
use App\Http\Controllers\CollectorPeshiController;
use App\Http\Controllers\AdminLeaveController;



Route::get('forgot-password', [UserController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [UserController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [UserController::class, 'reset'])->name('password.update');

Route::get('change_password', [UserController::class, 'ChangePassword'])->name('password.change');
Route::post('update_password', [UserController::class, 'UpdatePassword'])->name('password.change.post');

Route::post('/employee/store', [UserController::class, 'employeeStore'])->name('employee_register.store');



Route::post('/user/store', [UserController::class, 'UserStore'])->name('register.store');

Route::get('login', function () {
    return view('login');
})->name('login');

Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::post('/user/check', [UserController::class, 'UserCheck'])->name('user.check');

Route::middleware('auth')->group(function () {

    Route::post('order_tracking/store', [OrderTrackingController::class, 'store'])->name('order_tracking.store');
    Route::get('/create_order_tracking', [OrderTrackingController::class, 'create'])->name('order_tracking.create');

    Route::get('/order_data', [OrderTrackingController::class, 'orderDataIndex'])->name('order_data.index');
    Route::post('/order_data/store', [OrderTrackingController::class, 'orderDataStore'])->name('order_data.store');

});

Route::get('/', [OrderTrackingController::class, 'index'])->name('order_tracking.index');


Route::get('/order_records', [OrderTrackingController::class, 'orderRecords'])->name('order_records.index');


