<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\Auth\LoginController;
use App\Http\Controllers\Superadmin\Auth\MyAccountController;
use App\Http\Controllers\Superadmin\Auth\ResetPasswordController;
use App\Http\Controllers\Superadmin\Auth\ChangePasswordController;
use App\Http\Controllers\Superadmin\Auth\ForgotPasswordController;
use App\Http\Controllers\Superadmin\LeadManagement\LeadController;
use App\Http\Controllers\Superadmin\QuotationManagement\QuotationController;
use App\Http\Controllers\Superadmin\TaskManagement\TaskController;
use App\Http\Controllers\Superadmin\UserManagement\PermissionController;
use App\Http\Controllers\Superadmin\UserManagement\RoleController;
use App\Http\Controllers\Superadmin\UserManagement\UserController;

/*
|--------------------------------------------------------------------------
| Superadmin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.'], function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes | LOGIN | REGISTER
    |--------------------------------------------------------------------------
    */

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/update', [ResetPasswordController::class, 'reset'])->name('password.update');


    /*
    |--------------------------------------------------------------------------
    | Dashboard Route
    |--------------------------------------------------------------------------
    */

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Lead Management > Leads Route
    |--------------------------------------------------------------------------
    */
    Route::resource('lead-management/leads', LeadController::class, [
        'names' => [
            'index'         => 'leads.index',
            'create'        => 'leads.create',
            'update'        => 'leads.update',
            'edit'          => 'leads.edit',
            'store'         => 'leads.store',
            'show'          => 'leads.show',
            'destroy'       => 'leads.destroy',
        ]
    ]);

    Route::get('lead-management/leads/kanban/view', [LeadController::class, 'kanban'])->name('leads.kanban');

    Route::post('lead-management/leads/kanban/update-status', [LeadController::class, 'updateKanbanStatus'])->name('leads.kanban.update-status');

    Route::post('lead-management/leads/assign', [LeadController::class, 'assign'])->name('leads.assign');

    Route::post('lead-management/leads/bulk-delete', [LeadController::class, 'bulkDelete'])->name('leads.bulk-delete');

    Route::delete('lead-management/leads/{id}/delete-attachment', [LeadController::class, 'deleteAttachment'])->name('leads.delete-attachment');

    Route::put('lead-management/leads/{id}/update-status', [LeadController::class, 'updateStatus'])->name('leads.update-status');

    Route::put('lead-management/leads/{id}/save-note', [LeadController::class, 'saveNote'])->name('leads.save-note');

    Route::put('lead-management/leads/{id}/upload-attachments', [LeadController::class, 'uploadAttachments'])->name('leads.upload-attachments');

    /*
    |--------------------------------------------------------------------------
    | Task Management > Tasks Route
    |--------------------------------------------------------------------------
    */
    Route::resource('task-management/tasks', TaskController::class, [
        'names' => [
            'index'         => 'tasks.index',
            'create'        => 'tasks.create',
            'update'        => 'tasks.update',
            'edit'          => 'tasks.edit',
            'store'         => 'tasks.store',
            'show'          => 'tasks.show',
            'destroy'       => 'tasks.destroy',
        ]
    ]);

    Route::post('task-management/tasks/bulk-delete', [TaskController::class, 'bulkDelete'])->name('tasks.bulk-delete');

    Route::delete('task-management/tasks/{id}/delete-attachment', [TaskController::class, 'deleteAttachment'])->name('tasks.delete-attachment');

    /*
    |--------------------------------------------------------------------------
    | Quotation Management > Quotations Route
    |--------------------------------------------------------------------------
    */
    Route::resource('quotation-management/quotations', QuotationController::class, [
        'names' => [
            'index'         => 'quotations.index',
            'create'        => 'quotations.create',
            'update'        => 'quotations.update',
            'edit'          => 'quotations.edit',
            'store'         => 'quotations.store',
            'show'          => 'quotations.show',
            'destroy'       => 'quotations.destroy',
        ]
    ]);

    Route::post('quotation-management/quotations/bulk-delete', [QuotationController::class, 'bulkDelete'])->name('quotations.bulk-delete');

    /*
    |--------------------------------------------------------------------------
    | User Management > Users Route
    |--------------------------------------------------------------------------
    */
    Route::resource('user-management/users', UserController::class, [
        'names' => [
            'index'         => 'users.index',
            'create'        => 'users.create',
            'update'        => 'users.update',
            'edit'          => 'users.edit',
            'store'         => 'users.store',
            'show'          => 'users.show',
            'destroy'       => 'users.destroy',
        ]
    ]);

    Route::get('user-management/users/change-status/{id}', [UserController::class, 'changeStatus'])->name('users.change-status');
    Route::post('user-management/users/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('user-management/users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk-delete');

    /*
    |--------------------------------------------------------------------------
    | User Management > Roles Route
    |--------------------------------------------------------------------------
    */
    Route::resource('user-management/roles', RoleController::class, [
        'names' => [
            'index'         => 'roles.index',
            'create'        => 'roles.create',
            'update'        => 'roles.update',
            'edit'          => 'roles.edit',
            'store'         => 'roles.store',
            'show'          => 'roles.show',
            'destroy'       => 'roles.destroy',
        ]
    ]);

    /*
    |--------------------------------------------------------------------------
    | User Management > Permissions Route
    |--------------------------------------------------------------------------
    */
    Route::resource('user-management/permissions', PermissionController::class, [
        'names' => [
            'index'         => 'permissions.index',
            'create'        => 'permissions.create',
            'update'        => 'permissions.update',
            'edit'          => 'permissions.edit',
            'store'         => 'permissions.store',
            'show'          => 'permissions.show',
            'destroy'       => 'permissions.destroy',
        ]
    ]);

    /*
    |--------------------------------------------------------------------------
    | Settings > My Account Route
    |--------------------------------------------------------------------------
    */
    Route::resource('my-account', MyAccountController::class);

    /*
    |--------------------------------------------------------------------------
    | Settings > Change Password Route
    |------------------------------------------------------------------  --------
    */
    Route::get('change-password', [ChangePasswordController::class, 'changePasswordForm'])->name('password.form');

    Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');
});
