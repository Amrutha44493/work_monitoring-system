<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FittingTypeController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\TeamLeaderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\WorkAssignmentController;
use App\Http\Controllers\Admin\WorkLogController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
//App\Http\Controllers\Admin\ProfileController;

// Team Leader Controllers
use App\Http\Controllers\TeamLeader\DashboardController as TLDashboard;
use App\Http\Controllers\TeamLeader\AssignmentController as TLAssignment;
use App\Http\Controllers\TeamLeader\WorkLogController as TLWorkLog;
use App\Http\Controllers\TeamLeader\ReportController as TLReport;

Route::get('/', function() {
    if(!Auth::check()) {
        return redirect()->route('login');
    }
    if(Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    if(Auth::user()->hasRole('team_leader')) {
        return redirect()->route('tl.dashboard');
    }
    return redirect()->route('login');
})->name('home');

//Admin
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function() {

    // Dashboard
    Route::get('/dashboard',
        [DashboardController::class, 'index'])
        ->name('dashboard');
    // Masters
    Route::resource('categories', CategoryController::class);
    Route::resource('fitting-types', FittingTypeController::class);
    Route::resource('team-leaders', TeamLeaderController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('users', UserController::class);
    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/items',
        [ProjectController::class, 'addItem'])
        ->name('projects.items.add');
    Route::delete('projects/{project}/items/{item}',
        [ProjectController::class, 'removeItem'])
        ->name('projects.items.remove');
    // Work
    Route::resource('assignments', WorkAssignmentController::class);
    Route::post('work-logs/start/{assignment}',
        [WorkLogController::class, 'start'])
        ->name('work-logs.start');
    Route::post('work-logs/stop/{workLog}',
        [WorkLogController::class, 'stop'])
        ->name('work-logs.stop');
    Route::resource('work-logs', WorkLogController::class);
    // Reports
    Route::prefix('reports')->name('reports.')->group(function() {
        Route::get('/daily',
            [ReportController::class, 'daily'])
            ->name('daily');
        Route::get('/employee',
            [ReportController::class, 'employee'])
            ->name('employee');
        Route::get('/productivity',
            [ReportController::class, 'productivity'])
            ->name('productivity');
        Route::get('/standard-vs-actual',
            [ReportController::class, 'standardVsActual'])
            ->name('standard-vs-actual');
        Route::get('/pending',
            [ReportController::class, 'pending'])
            ->name('pending');
        Route::get('/completed',
            [ReportController::class, 'completed'])
            ->name('completed');
        Route::get('/product-wise',
            [ReportController::class, 'productWise'])
            ->name('product-wise');

        Route::get('/daily/pdf',
            [ReportController::class, 'exportDailyPdf'])
            ->name('daily.pdf');
        Route::get('/daily/excel',
            [ReportController::class, 'exportDailyExcel'])
            ->name('daily.excel');
    });
});

// Teamleader
Route::prefix('team-leader')
    ->middleware(['auth', 'role:team_leader|admin'])
    ->name('tl.')
    ->group(function() {

    // Dashboard
    Route::get('/dashboard',
        [TLDashboard::class, 'index'])
        ->name('dashboard');
    Route::get('/employees',
        [TLDashboard::class, 'employees'])
        ->name('employees');
    // Assignments
    Route::get('/assign',
        [TLAssignment::class, 'index'])
        ->name('assign.index');
    Route::get('/assign/create',
        [TLAssignment::class, 'create'])
        ->name('assign.create');
    Route::post('/assign',
        [TLAssignment::class, 'store'])
        ->name('assign.store');
    Route::delete('/assign/{assignment}',
        [TLAssignment::class, 'destroy'])
        ->name('assign.destroy');
    Route::get('/work-status',
        [TLWorkLog::class, 'index'])
        ->name('work.index');
    Route::post('/work/start/{assignment}',
        [TLWorkLog::class, 'start'])
        ->name('work.start');
    Route::post('/work/stop/{workLog}',
        [TLWorkLog::class, 'stop'])
        ->name('work.stop');
        Route::get('/profile',
    [\App\Http\Controllers\TeamLeader\ProfileController::class, 'index'])
    ->name('profile');
Route::post('/profile/password',
    [\App\Http\Controllers\TeamLeader\ProfileController::class, 'updatePassword'])
    ->name('profile.password');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function() {
        Route::get('/daily',
            [TLReport::class, 'daily'])
            ->name('daily');
        Route::get('/employee',
            [TLReport::class, 'employee'])
            ->name('employee');
        Route::get('/product',
            [TLReport::class, 'product'])
            ->name('product');
        Route::get('/productivity',
            [TLReport::class, 'productivity'])
            ->name('productivity');
        Route::get('/standard-actual',
            [TLReport::class, 'standardActual'])
            ->name('standard-actual');
        Route::get('/pending',
            [TLReport::class, 'pending'])
            ->name('pending');
        Route::get('/completed',
            [TLReport::class, 'completed'])
            ->name('completed');
    });
});

require __DIR__.'/auth.php';
