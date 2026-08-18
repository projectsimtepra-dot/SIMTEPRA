<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware([
        'auth',
        'verified',
        'permission:dashboard.view',
    ])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Manajemen Pengguna
        |--------------------------------------------------------------------------
        */

        Route::get('users', [UserController::class, 'index'])
            ->middleware('permission:users.view')
            ->name('users.index');

        Route::get('users/create', [UserController::class, 'create'])
            ->middleware('permission:users.create')
            ->name('users.create');

        Route::post('users', [UserController::class, 'store'])
            ->middleware('permission:users.create')
            ->name('users.store');

        Route::get('users/{id}', [UserController::class, 'show'])
            ->middleware('permission:users.view')
            ->name('users.show');

        Route::get('users/{id}/edit', [UserController::class, 'edit'])
            ->middleware('permission:users.edit')
            ->name('users.edit');

        Route::put('users/{id}', [UserController::class, 'update'])
            ->middleware('permission:users.edit')
            ->name('users.update');

        Route::delete('users/{id}', [UserController::class, 'destroy'])
            ->middleware('permission:users.delete')
            ->name('users.destroy');


        /*
        |--------------------------------------------------------------------------
        | Manajemen Role
        |--------------------------------------------------------------------------
        */

        Route::get('roles', [RoleController::class, 'index'])
            ->middleware('permission:roles.view')
            ->name('roles.index');

        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])
            ->middleware('permission:roles.edit')
            ->name('roles.edit');

        Route::put('roles/{role}', [RoleController::class, 'update'])
            ->middleware('permission:roles.edit')
            ->name('roles.update');


        /*
        |--------------------------------------------------------------------------
        | Manajemen Permission
        |--------------------------------------------------------------------------
        */

        Route::get('permissions', [PermissionController::class, 'index'])
            ->middleware('permission:permissions.view')
            ->name('permissions.index');

        Route::get('permissions/create', [PermissionController::class, 'create'])
            ->middleware('permission:permissions.create')
            ->name('permissions.create');

        Route::post('permissions', [PermissionController::class, 'store'])
            ->middleware('permission:permissions.create')
            ->name('permissions.store');

        Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])
            ->middleware('permission:permissions.edit')
            ->name('permissions.edit');

        Route::put('permissions/{permission}', [PermissionController::class, 'update'])
            ->middleware('permission:permissions.edit')
            ->name('permissions.update');

        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])
            ->middleware('permission:permissions.delete')
            ->name('permissions.destroy');

    });


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])
    ->group(function () {

        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');

    });


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';