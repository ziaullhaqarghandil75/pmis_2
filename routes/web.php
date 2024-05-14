<?php

use App\Http\Controllers\AccountSetting\PermissionCategoryController;
use App\Http\Controllers\AccountSetting\PermissionController;
use App\Http\Controllers\AccountSetting\RoleController;
use App\Http\Controllers\AccountSetting\UserController;
use App\Http\Controllers\plan\DepratmentController;
use App\Http\Controllers\Plan\DistrictController;
use App\Http\Controllers\Plan\GoalCategoryController;
use App\Http\Controllers\Plan\GoalController;
use App\Http\Controllers\Plan\UnitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Project\DepartmentActivityController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\ProjectTrackingController;
use App\Http\Controllers\Project\ReportProjectTrackingController;
use App\Models\Project\Project;
use App\Models\Project\ReportProjectTracking;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Can;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
// Route::resource('/role', ::class);
// Route::resource('/user', PermissionController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    //  start account settings
    Route::resource('/user', UserController::class);
    Route::patch('/change_password/{id}', [UserController::class, 'change_password'])->name('user.change_password');
    Route::get('/user_status/{id}', [UserController::class,'user_status'])->name('user_status.user_status');

    Route::resource('/permission', PermissionController::class);
    Route::resource('/permission_category', PermissionCategoryController::class);
    Route::resource('/role', RoleController::class);
    Route::get('/status/{id}', [RoleController::class,'status_role'])->name('status.status_role');
    //  end account settings

    //  start plan settings
    Route::resource('/department', DepratmentController::class);
    Route::patch('/department', [DepratmentController::class, 'status'])->name('department.status');
    Route::resource('/goal_category', GoalCategoryController::class);
    Route::resource('/goal', GoalController::class);
    Route::resource('/district', DistrictController::class);
    Route::resource('/unit', UnitController::class);
    //  end plan settings

    //  start project settings
    Route::resource('/project', ProjectController::class);
    Route::resource('/project_tracking', ProjectTrackingController::class);
    Route::patch('/budget_after_design/{id}', [ProjectTrackingController::class,'add_budget_after_design'])->name('budget_after_design.add_budget_after_design');
    Route::patch('/contract_budget/{id}', [ProjectTrackingController::class,'add_contract_budget'])->name('contract_budget.add_contract_budget');

    Route::post('/report_project_tracking', [ReportProjectTrackingController::class, 'store'])->name('report_project_tracking.store');
    Route::get('/report_project_tracking/{id}/department_id/{department_id}/project_tracking_id/{project_tracking_id}', [ReportProjectTrackingController::class, 'show'])->name('report_project_tracking.show');
    Route::resource('/department_activity', DepartmentActivityController::class);
    Route::get('/status_department_activity/{id}/department_id/{department_id}', [DepartmentActivityController::class,'status_department_activity'])->name('department_activity.status_department_activity');

    //  start project settings

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
