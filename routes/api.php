<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('clear-compiled');
//    \Illuminate\Support\Facades\Artisan::call('optimize');
//    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
});

Route::post('/login', [App\Http\Controllers\Api\LoginController::class, 'index'])->name('login');



//Route::post('/form',[\App\Http\Controllers\Api\LoginController::class,'form'])->name('form')->middleware('auth:api');

Route::middleware(['auth:api','cors'])->group(function () {
   // Route::post('/form',[\App\Http\Controllers\Api\LoginController::class,'form'])->name('form');
    Route::post('get_guard_schedules',[\App\Http\Controllers\Api\ScheduleController::class,'get_guard_schedules'])
        ->name('get_guard_schedules');
    Route::post('create_guard_attendance',[\App\Http\Controllers\Api\AttendanceController::class,'save_guard_attendance'])
        ->name('create_guard_attendance');
    Route::post('create_guard_attendance_by_schedule',[\App\Http\Controllers\Api\AttendanceController::class,'save_guard_attendance_by_schedule'])
        ->name('create_guard_attendance_by_schedule');
    Route::post('check_guard_time_out',[\App\Http\Controllers\Api\AttendanceController::class,'check_guard_time_out'])
        ->name('check_guard_time_out');
    Route::post('get_guard_attendance',[\App\Http\Controllers\Api\AttendanceController::class,'get_guard_attendance'])
        ->name('get_guard_attendance');
    Route::post('save_checkpoint_history',[\App\Http\Controllers\Api\CheckpointController::class,'save_history_checkpoint'])
        ->name('save_checkpoint_history');
    Route::post('get_checkpoint_history',[\App\Http\Controllers\Api\CheckpointController::class,'get_qrcode_history'])
        ->name('get_checkpoint_history');
//    Daily Report
    Route::post('save_daily_report',[\App\Http\Controllers\Api\DailyReportController::class,'save_daily_report'])
        ->name('save_daily_report');
    Route::post('get_daily_reports_by_schedule',[\App\Http\Controllers\Api\DailyReportController::class,'get_daily_reports_by_schedule'])
        ->name('get_daily_reports_by_schedule');

    //    Visitor Report
    Route::post('save_visitor_report',[\App\Http\Controllers\Api\VisitorController::class,'save_visitor_report'])
        ->name('save_visitor_report');
    Route::post('get_visitor_report_by_schedule',[\App\Http\Controllers\Api\VisitorController::class,'get_visitor_report_by_schedule'])
        ->name('get_visitor_report_by_schedule');
    Route::post('visitor_time_out',[\App\Http\Controllers\Api\VisitorController::class,'visitor_time_out'])
        ->name('visitor_time_out');
//    Notifications
    Route::post('get_all_notifications',[\App\Http\Controllers\Api\NotificationController::class,'get_all_notifications'])
        ->name('get_all_notifications');
//    Mobile Patrols
    Route::post('get_all_mobile_patrols',[\App\Http\Controllers\Api\MobilePatrolController::class,'get_all_mobile_patrols'])
        ->name('get_all_mobile_patrols');
    Route::post('get_all_mobile_patrols_reports_by_id',[\App\Http\Controllers\Api\MobilePatrolController::class,'get_all_mobile_patrols_reports_by_id'])
        ->name('get_all_mobile_patrols_reports_by_id');

    Route::post('save_mobile_patrol_report',[\App\Http\Controllers\Api\MobilePatrolController::class,'save_mobile_patrol_report'])
        ->name('save_mobile_patrol_report');

    Route::post('change_mobile_patrol_status',[\App\Http\Controllers\Api\MobilePatrolController::class,'change_mobile_patrol_status'])
        ->name('change_mobile_patrol_status');

    Route::post('get_forms',[\App\Http\Controllers\Api\FormController::class,'index'])
        ->name('get_forms');

    Route::post('save_forms_value',[\App\Http\Controllers\Api\FormController::class,'save_forms_value'])
        ->name('save_forms_value');

    Route::post('get_admin_clients',[\App\Http\Controllers\Api\AttendanceController::class,'get_admin_clients'])
        ->name('get_admin_clients');

    Route::post('save_dispatch_report',[\App\Http\Controllers\Api\DispatchController::class,'save_dispatch_report'])
        ->name('save_dispatch_report');

    Route::post('save_incident_report',[\App\Http\Controllers\Api\IncidentController::class,'save_incident_report'])
        ->name('save_incident_report');

    Route::post('save_yard_report',[\App\Http\Controllers\Api\YardController::class,'save_yard_report'])
        ->name('save_yard_report');

});


