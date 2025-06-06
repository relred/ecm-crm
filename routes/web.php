<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\ExternalRegisterController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\MonitorDashboardController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PromotedController;
use App\Http\Controllers\PromotedImportController;
use App\Http\Controllers\PromoterController;
use App\Http\Controllers\SubcoordinatorController;
use App\Http\Controllers\MobilizationActivityController;
use App\Http\Controllers\SpecialSupporterController;
use App\Http\Controllers\MobilizationController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\MobilizationEstimateController;
use App\Http\Controllers\DdayMonitoringController;
use App\Http\Controllers\DdayReportController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/* Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard'); */

Route::get('/dashboard', function(){
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('coordinators.index');
    }
    
    if ($user->isCoordinator()) {
        return redirect()->route('coordinator.dashboard');
    }

    if ($user->isOperator()) {
        return redirect()->route('promoters');
    }

    if ($user->isSubcoordinator()) {
        return redirect()->route('subcoordinator.dashboard');
    }

    if ($user->isPromoter()) {
        return redirect()->route('promoted.index');
    }

    if ($user->isMonitor()) {
        return redirect()->route('admin.dday-monitoring.index');
    }

    // Optional fallback if none match
    abort(403, 'Unauthorized');
})->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Mobilization Activity Routes
    Route::get('/befTAmt6', [MobilizationActivityController::class, 'showConfirmation'])
        ->name('mobilization.confirm');
    Route::post('/befTAmt6', [MobilizationActivityController::class, 'confirm']);
    Route::get('/mobilization/confirmed', [MobilizationActivityController::class, 'showConfirmed'])
        ->name('mobilization.confirmed');
    
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/coordinatos', [CoordinatorController::class, 'index'])->name('coordinators.index');
    Route::get('/admin/coordinators/create', [CoordinatorController::class, 'create'])->name('coordinators.create');
    Route::post('/admin/coordinators', [CoordinatorController::class, 'store'])->name('coordinators.store');
    Route::get('/admin/special-supporters', [SpecialSupporterController::class, 'index'])->name('admin.special-supporters.index');
    Route::post('/admin/special-supporters/create-link', [SpecialSupporterController::class, 'createLink'])->name('admin.special-supporters.create-link');
    Route::patch('/admin/special-supporters/{supporter}/update-mobilized', [SpecialSupporterController::class, 'updateMobilized'])->name('admin.special-supporters.update-mobilized');
});

Route::middleware(['auth', 'role:coordinator'])->group(function () {
    Route::get('/coordinator/subcoordinators', [SubcoordinatorController::class, 'index'])->name('coordinator.subcoordinators.index');
    Route::get('/coordinator/subcoordinators/create', [SubcoordinatorController::class, 'create'])->name('coordinator.subcoordinators.create');
    Route::post('/coordinator/subcoordinators', [SubcoordinatorController::class, 'store'])->name('coordinator.subcoordinators.store');
    Route::get('/coordinator/dashboard', [CoordinatorController::class, 'dashboard'])->name('coordinator.dashboard');
    Route::get('/coordinator/subcoordinator-stats', [CoordinatorController::class, 'subcoordinatorStats'])->name('coordinator.subcoordinator-stats');
    Route::get('/coordinator/subcoordinators/{subcoordinator}', [SubcoordinatorController::class, 'view'])->name('coordinator.subcoordinators.view');
    Route::get('/mobilization/manage-subcoordinators', [MobilizationActivityController::class, 'manageSubcoordinators'])->name('mobilization.manage-subcoordinators');
});

Route::middleware(['auth', 'role:coordinator,subcoordinator,operator'])->group(function () {
    Route::get('/mobilization/estimate', [MobilizationEstimateController::class, 'showEstimateForm'])
        ->name('mobilization.estimate');
    Route::post('/mobilization/estimate/goal', [MobilizationEstimateController::class, 'submitGoal'])
        ->name('mobilization.estimate.goal.submit');
    Route::get('/LTEA6pyP', [MobilizationEstimateController::class, 'showUpdateForm'])
        ->name('mobilization.estimate.update');
    Route::post('/LTEA6pyP', [MobilizationEstimateController::class, 'submitEstimate'])
        ->name('mobilization.estimate.update.submit');

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/operators', [OperatorController::class, 'index'])->name('operators');
    Route::get('/operators/create', [OperatorController::class, 'create'])->name('operators.create');
    Route::post('/operators', [OperatorController::class, 'store'])->name('operators.store');
    Route::get('/import-promoted', [PromotedController::class, 'importView'])->name('promoted.import');
    Route::post('/import-promoted', [PromotedController::class, 'import'])->name('promoted.import.store');
    Route::get('/import-promoted/history', [PromotedImportController::class, 'history'])->name('promoted.import.history');
    Route::post('/import-promoted/{import}/rollback', [PromotedImportController::class, 'rollback'])->name('promoted.import.rollback');
    Route::get('/states', [StateController::class, 'index'])->name('states.index');
    Route::get('/states/{state}/edit', [StateController::class, 'edit'])->name('states.edit');
    Route::put('/states/{state}', [StateController::class, 'update'])->name('states.update');
});

Route::middleware(['auth', 'role:subcoordinator,operator'])->group(function () {
    Route::get('/promoters', [PromoterController::class, 'index'])->name('promoters');
    Route::get('/promoters/create', [PromoterController::class, 'create'])->name('promoters.create');
    Route::post('/promoters', [PromoterController::class, 'store'])->name('promoters.store');
    Route::get('/subcoordinator/dashboard', [SubcoordinatorController::class, 'dashboard'])->name('subcoordinator.dashboard');
    Route::get('/promoter-stats', [SubcoordinatorController::class, 'promoterStats'])->name('subcoordinator.promoter-stats');
    Route::get('/promoters/{promoter}', [PromoterController::class, 'view'])->name('promoters.view');
    Route::get('/mobilization/manage-promoters', [MobilizationActivityController::class, 'managePromoters'])->name('mobilization.manage-promoters');
});

Route::middleware(['auth', 'role:promoter,operator'])->group(function () {
    Route::get('/promoted/create', [PromotedController::class, 'create'])->name('promoted.create');
    Route::post('/promoted', [PromotedController::class, 'store'])->name('promoted.store');
    Route::get('/promoted', [PromotedController::class, 'index'])->name('promoted.index');
    Route::get('/promoted/{promoted}', [PromotedController::class, 'view'])->name('promoted.view');
    Route::get('/promoted/{promoted}/follow-up', [FollowUpController::class, 'index'])->name('followup.index');
    Route::post('/promoted/{promoted}/follow-up/touch', [FollowUpController::class, 'storeTouch'])->name('followup.touch.store');
    Route::get('/promoted/{promoted}/transport', [FollowUpController::class, 'editTransport'])->name('followup.transport');
    Route::patch('/promoted/{promoted}/transport', [FollowUpController::class, 'updateTransport'])->name('followup.transport.update');
    Route::get('/promoted/{promoted}/mobilization', [MobilizationController::class, 'index'])->name('mobilization.index');
    Route::patch('/promoted/{promoted}/mobilization', [MobilizationController::class, 'update'])->name('mobilization.update');
});

Route::middleware(['auth', 'role:monitor,admin'])->group(function () {
    Route::get('/monitor/dashboard', [MonitorDashboardController::class, 'index'])->name('monitor.dashboard');
    Route::get('/monitor/state-comparison', [MonitorDashboardController::class, 'stateComparison'])->name('monitor.state-comparison');
    Route::get('/mobilization/analytics', [MobilizationActivityController::class, 'analytics'])->name('mobilization.analytics');
    Route::get('/admin/dday-monitoring', [DdayMonitoringController::class, 'index'])->name('admin.dday-monitoring.index');
});

Route::get('/external-register/{parent}/{roleHash}', [ExternalRegisterController::class, 'showForm'])
    ->name('external.register');
Route::post('/external-register', [ExternalRegisterController::class, 'submitForm'])
->name('external.register.submit');

// Special Supporters Public Routes
Route::get('/special/register/{token}', [SpecialSupporterController::class, 'showRegistrationForm'])->name('special.register');
Route::post('/special/register/{token}', [SpecialSupporterController::class, 'register'])->name('special.register.submit');
Route::get('/special/success', function() {
    return view('special-supporters.success');
})->name('special.success');

Route::get('/dday-report', [DdayReportController::class, 'index'])->name('dday.report');
Route::get('/dday-report/subcoordinators/{state}', [DdayReportController::class, 'subcoordinators'])->name('dday.subcoordinators');

require __DIR__.'/auth.php';
