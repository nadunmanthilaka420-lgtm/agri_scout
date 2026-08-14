<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;

use App\Http\Controllers\FarmerDashboardController;
use App\Http\Controllers\FarmerFarmController;
use App\Http\Controllers\FarmerCropController;
use App\Http\Controllers\FarmerDiseaseController;
use App\Http\Controllers\FarmerVisitController;
use App\Http\Controllers\FarmerOrderController;
use App\Http\Controllers\FarmerProfileController;

use App\Http\Controllers\OfficerDashboardController;
use App\Http\Controllers\OfficerFarmController;
use App\Http\Controllers\OfficerVisitController;
use App\Http\Controllers\OfficerVisitReportController;
use App\Http\Controllers\OfficerCropController;
use App\Http\Controllers\OfficerDiseaseController;
use App\Http\Controllers\OfficerProfileController;

use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\CustomerCropController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

/*

| ADMIN AUTH & DASHBOARD (Preserved)

*/
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('/add_farmer', [AdminAuthController::class, 'add_farmer'])->name('admin.add_farmer');
Route::post('/new_farmer', [AdminAuthController::class, 'new_farmer']);
Route::get('/view_farmers', [AdminAuthController::class, 'view_farmers'])->name('admin.view_farmers');
Route::post('/admin/farmers/{id}', [AdminAuthController::class, 'update_farmer'])->name('admin.update_farmer');
Route::delete('/admin/farmers/{id}', [AdminAuthController::class, 'delete_farmer'])->name('admin.delete_farmer');
Route::get('/view_farms', [AdminAuthController::class, 'view_farms'])->name('admin.view_farms');
Route::post('/admin/farms/{id}', [AdminAuthController::class, 'update_farm'])->name('admin.update_farm');
Route::delete('/admin/farms/{id}', [AdminAuthController::class, 'delete_farm'])->name('admin.delete_farm');
Route::get('/add_farm', [AdminAuthController::class, 'add_farm'])->name('admin.add_farm');
Route::post('/new_farm', [AdminAuthController::class, 'new_farm']);
Route::get('/add_officer', [AdminAuthController::class, 'add_officer'])->name('admin.add_officer');
Route::post('/new_officer', [AdminAuthController::class, 'new_officer'])->name('admin.new_officer');
Route::get('/view_officers', [AdminAuthController::class, 'view_officers'])->name('admin.view_officers');
Route::post('/admin/officers/{id}', [AdminAuthController::class, 'update_officer'])->name('admin.update_officer');
Route::delete('/admin/officers/{id}', [AdminAuthController::class, 'delete_officer'])->name('admin.delete_officer');
Route::get('/view_customers', [AdminAuthController::class, 'view_customers'])->name('admin.view_customers');
Route::post('/admin/customers/{id}/status', [AdminAuthController::class, 'update_customer_status'])->name('admin.update_customer_status');
Route::delete('/admin/customers/{id}', [AdminAuthController::class, 'delete_customer'])->name('admin.delete_customer');
Route::get('/view_orders', [AdminAuthController::class, 'view_orders'])->name('admin.view_orders');
Route::get('/view_crops', [AdminAuthController::class, 'view_crops'])->name('admin.view_crops');

/*

 ADMIN CROP MANAGEMENT ROUTES

*/
Route::get('/admin/crops', [\App\Http\Controllers\AdminCropController::class, 'index'])->name('admin.crops.index');
Route::get('/admin/crops/create', [\App\Http\Controllers\AdminCropController::class, 'create'])->name('admin.crops.create');
Route::post('/admin/crops', [\App\Http\Controllers\AdminCropController::class, 'store'])->name('admin.crops.store');
Route::get('/admin/crops/{id}/edit', [\App\Http\Controllers\AdminCropController::class, 'edit'])->name('admin.crops.edit');
Route::put('/admin/crops/{id}', [\App\Http\Controllers\AdminCropController::class, 'update'])->name('admin.crops.update');
Route::delete('/admin/crops/{id}', [\App\Http\Controllers\AdminCropController::class, 'destroy'])->name('admin.crops.destroy');

Route::get('/view_visit_reports', [AdminAuthController::class, 'view_visit_reports'])->name('admin.view_visit_reports');
Route::get('/view_disease_reports', [AdminAuthController::class, 'view_disease_reports'])->name('admin.view_disease_reports');
Route::post('/admin/disease_reports/{id}/status', [AdminAuthController::class, 'update_disease_status'])->name('admin.update_disease_status');
Route::delete('/admin/disease_reports/{id}', [AdminAuthController::class, 'delete_disease_report'])->name('admin.delete_disease_report');
Route::get('/view_activity_logs', [AdminAuthController::class, 'view_activity_logs'])->name('admin.view_activity_logs');




/*

| USER AUTH & CENTRAL REDIRECT

*/
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [UserAuthController::class, 'register'])->name('register.submit');
Route::get('/dashboard', [UserAuthController::class, 'dashboard'])->name('user.dashboard');
Route::get('/logout', [UserAuthController::class, 'logout'])->name('logout');

/*

| FARMER DASHBOARD & ROUTES

*/
Route::prefix('farmer')->middleware(['role:farmer'])->group(function () {
    Route::get('/dashboard', [FarmerDashboardController::class, 'index'])->name('farmer.dashboard');

    Route::get('/farms', [FarmerFarmController::class, 'index'])->name('farmer.farms.index');
    Route::get('/farms/{id}', [FarmerFarmController::class, 'show'])->name('farmer.farms.show');

    Route::get('/crops', [FarmerCropController::class, 'index'])->name('farmer.crops.index');
    Route::get('/diseases', [FarmerDiseaseController::class, 'index'])->name('farmer.diseases.index');
    Route::get('/visits', [FarmerVisitController::class, 'index'])->name('farmer.visits.index');
    Route::get('/orders', [FarmerOrderController::class, 'index'])->name('farmer.orders.index');
    Route::post('/orders/{id}/status', [FarmerOrderController::class, 'updateStatus'])->name('farmer.orders.update_status');

    Route::get('/profile', [FarmerProfileController::class, 'index'])->name('farmer.profile.index');
    Route::post('/profile', [FarmerProfileController::class, 'update'])->name('farmer.profile.update');
});

/*

| FIELD OFFICER DASHBOARD & ROUTES

*/
Route::prefix('officer')->middleware(['role:field_officer'])->group(function () {
    Route::get('/dashboard', [OfficerDashboardController::class, 'index'])->name('officer.dashboard');

    Route::get('/farms', [OfficerFarmController::class, 'index'])->name('officer.farms.index');
    Route::get('/farms/{id}', [OfficerFarmController::class, 'show'])->name('officer.farms.show');

    Route::get('/visits', [OfficerVisitController::class, 'index'])->name('officer.visits.index');
    Route::get('/visits/create', [OfficerVisitController::class, 'create'])->name('officer.visits.create');
    Route::post('/visits', [OfficerVisitController::class, 'store'])->name('officer.visits.store');
    Route::get('/visits/{id}', [OfficerVisitController::class, 'show'])->name('officer.visits.show');
    Route::get('/visits/{id}/edit', [OfficerVisitController::class, 'edit'])->name('officer.visits.edit');
    Route::put('/visits/{id}', [OfficerVisitController::class, 'update'])->name('officer.visits.update');

    Route::get('/visit-reports/create', [OfficerVisitReportController::class, 'create'])->name('officer.visit-reports.create');
    Route::post('/visit-reports', [OfficerVisitReportController::class, 'store'])->name('officer.visit-reports.store');

    Route::get('/crops', [OfficerCropController::class, 'index'])->name('officer.crops.index');

    Route::get('/diseases', [OfficerDiseaseController::class, 'index'])->name('officer.diseases.index');
    Route::get('/diseases/create', [OfficerDiseaseController::class, 'create'])->name('officer.diseases.create');
    Route::post('/diseases', [OfficerDiseaseController::class, 'store'])->name('officer.diseases.store');
    Route::get('/diseases/{id}', [OfficerDiseaseController::class, 'show'])->name('officer.diseases.show');
    Route::post('/diseases/{id}/follow-up', [OfficerDiseaseController::class, 'addFollowUp'])->name('officer.diseases.follow-up');

    Route::get('/profile', [OfficerProfileController::class, 'index'])->name('officer.profile.index');
    Route::post('/profile', [OfficerProfileController::class, 'update'])->name('officer.profile.update');
});

/*

| CUSTOMER DASHBOARD & ROUTES

*/
Route::prefix('customer')->middleware(['role:customer'])->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

    Route::get('/crops', [CustomerCropController::class, 'index'])->name('customer.crops.index');
    Route::get('/crops/{id}', [CustomerCropController::class, 'show'])->name('customer.crops.show');

    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/orders/create', [CustomerOrderController::class, 'create'])->name('customer.orders.create');
    Route::post('/orders', [CustomerOrderController::class, 'store'])->name('customer.orders.store');
    Route::get('/orders/{id}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');
    Route::post('/orders/{id}/cancel', [CustomerOrderController::class, 'cancel'])->name('customer.orders.cancel');

    Route::get('/profile', [CustomerProfileController::class, 'index'])->name('customer.profile.index');
    Route::post('/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
});
