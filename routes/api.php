<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/customers/search', [CustomerController::class, 'search']);
Route::get('/customers/live/search', [CustomerController::class, 'livesearch']);
Route::get('/customers/get/total_rows', [CustomerController::class, 'totalRows']);
Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::get('/customers/create', [CustomerController::class, 'create']);
Route::post('/customers/store', [CustomerController::class, 'store']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);


Route::get('/users/search', [UserController::class, 'search']);
Route::get('/users/live/search', [UserController::class, 'livesearch']);
Route::get('/users/get/total_rows', [UserController::class, 'totalRows']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/create', [UserController::class, 'create']);
Route::post('/users/store', [UserController::class, 'store']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::put('/users/{id}', [UserController::class, 'update']);

Route::get('/employees/search', [EmployeeController::class, 'search']);
Route::get('/employees/live/search', [EmployeeController::class, 'livesearch']);
Route::get('/employees/get/total_rows', [EmployeeController::class, 'totalRows']);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/{id}', [EmployeeController::class, 'show']);

Route::post('/employees/store', [EmployeeController::class, 'store']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
Route::post('/employees/{id}', [EmployeeController::class, 'update']);   // NOTE: Route should be PUT method but laravel cannot handle PUT method with vue FormData so post is used

Route::get('/employees/{id}/payroll/history', [PayrollController::class, 'getPayrollHistory']);
Route::post('/employees/{id}/payroll', [PayrollController::class, 'saveRecord']);
Route::get('/employees/payroll/date', [PayrollController::class, 'getPayrollDate']);

Route::get('/payroll/{id}', [PayrollController::class, 'show']);
Route::post('/payroll/{id}', [PayrollController::class, 'update']);
Route::delete('/payroll/{id}', [PayrollController::class, 'destroy']);

Route::resource('/invoices', InvoiceController::class);
Route::get('/invoices/live/search', [InvoiceController::class, 'livesearch']);
Route::get('/invoices/get/total_rows', [InvoiceController::class, 'totalRows']);
Route::get('/invoices/date/search', [InvoiceController::class, 'dateSearch']);
Route::get('/invoices/status/search', [InvoiceController::class, 'statusSearch']);
Route::post('/invoices/item/remove/{invoiceId}/{id}/{qty}', [InvoiceController::class, 'itemRemove']);

Route::resource('/products', ProductController::class);
Route::get('/search/products', [ProductController::class, 'search']);
Route::get('/products/live/search', [ProductController::class, 'livesearch']);
Route::get('/products/get/total_rows', [ProductController::class, 'totalRows']);

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);

Route::resource('/items', ItemController::class);
Route::get('/search/items', [ItemController::class, 'search']);
Route::get('/items/live/search', [ItemController::class, 'livesearch']);
Route::get('/items/get/total_rows', [ItemController::class, 'totalRows']);

Route::resource('/expenses', ExpenseController::class);
Route::get('/expenses/live/search', [ExpenseController::class, 'livesearch']);
Route::get('/expenses/get/total_rows', [ExpenseController::class, 'totalRows']);
Route::get('/expenses/date/search', [ExpenseController::class, 'dateSearch']);
Route::get('/expenses/status/search', [ExpenseController::class, 'statusSearch']);

Route::resource('/vendors', VendorController::class);
Route::get('/search/vendors', [VendorController::class, 'search']);
Route::get('/vendors/live/search', [VendorController::class, 'livesearch']);
Route::get('/vendors/get/total_rows', [VendorController::class, 'totalRows']);

Route::get('chartdata', [DashboardController::class, 'chartData']);
Route::get('income', [DashboardController::class, 'income']);
Route::get('totalincomes', [DashboardController::class, 'totalIncome']);
Route::get('totalexpenses', [DashboardController::class, 'totalExpense']);
Route::get('expense', [DashboardController::class, 'expense']);

Route::resource('/settings', SettingController::class);
Route::get('/get/settings', [SettingController::class, 'first']);

