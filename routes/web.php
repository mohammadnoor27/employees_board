<?php

use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('dashboard', [UserController::class, 'dashboard']);
Route::get('/', [UserController::class, 'index'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('login.user');
Route::get('signout', [UserController::class, 'signOut'])->name('signout');

Route::group(['middleware' => ['auth', 'hr'], 'prefix' => 'hr'], function () {
    Route::get('dashboard', [EmployeesController::class, 'hr_dashboard'])->name('hr.dashboard');
    Route::get('get-employee/{id}', [EmployeesController::class, 'get_employee'])->name('edit.employee');
    Route::get('del-employee/{id}', [EmployeesController::class, 'del_employee'])->name('del.employee');
    Route::post('new-employee', [EmployeesController::class, 'new_employee'])->name('admin.new.employee');
});

Route::group(['middleware' => ['auth', 'employee'], 'prefix' => 'employee'], function () {
    Route::get('dashboard', [EmployeesController::class, 'employee_dashboard'])->name('employee.dashboard');
    Route::get('get-employee/{id}', [EmployeesController::class, 'get_employee'])->name('edit.employee');
    Route::post('new-employee', [EmployeesController::class, 'new_employee'])->name('user.new.employee');
});
