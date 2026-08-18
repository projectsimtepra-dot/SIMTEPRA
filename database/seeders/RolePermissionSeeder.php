<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Reset Permission Cache
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        /*
        |--------------------------------------------------------------------------
        | Permissions SIMTEPRA
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Dashboard
            'dashboard.view',

            // User Management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Role & Permission
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',

            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',

            // Data Profil Pengadaan
            'procurement.view',
            'procurement.create',
            'procurement.edit',
            'procurement.delete',

            // Dokumen Pengadaan
            'procurement-documents.view',
            'procurement-documents.upload',
            'procurement-documents.delete',

            // Verifikasi
            'verification.view',
            'verification.approve',
            'verification.reject',
            'verification.comment',

            // Evaluasi
            'evaluations.view',
            'evaluations.create',
            'evaluations.edit',
            'evaluations.delete',

            // Laporan
            'reports.view',
            'reports.create',
            'reports.edit',
            'reports.delete',
            'reports.export',

            // Monitoring
            'monitoring.view',

            // Sinkronisasi Inaproc
            'inaproc.view',
            'inaproc.sync',

            // RPJMD
            'rpjmd.view',
            'rpjmd.create',
            'rpjmd.edit',
            'rpjmd.delete',

            // Renstra
            'renstra.view',
            'renstra.create',
            'renstra.edit',
            'renstra.delete',

            // Renja
            'renja.view',
            'renja.create',
            'renja.edit',
            'renja.delete',

            // Activity Log
            'audit-logs.view',

            // Profile
            'profile.view',
            'profile.edit',
            'password.change',
        ];


        /*
        |--------------------------------------------------------------------------
        | Create Permissions
        |--------------------------------------------------------------------------
        */

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Create Roles
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $viewer = Role::firstOrCreate([
            'name' => 'viewer',
            'guard_name' => 'web',
        ]);


        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        |
        | Super Admin memiliki seluruh permission.
        |
        */

        $superAdmin->syncPermissions(
            Permission::where('guard_name', 'web')->get()
        );


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin->syncPermissions([

            // Dashboard
            'dashboard.view',

            // User Management
            'users.view',
            'users.create',
            'users.edit',

            // Data Pengadaan
            'procurement.view',
            'procurement.create',
            'procurement.edit',
            'procurement.delete',

            // Dokumen
            'procurement-documents.view',
            'procurement-documents.upload',
            'procurement-documents.delete',

            // Verifikasi
            'verification.view',
            'verification.comment',

            // Evaluasi
            'evaluations.view',
            'evaluations.create',
            'evaluations.edit',

            // Laporan
            'reports.view',
            'reports.create',
            'reports.edit',
            'reports.export',

            // Monitoring
            'monitoring.view',

            // Inaproc
            'inaproc.view',
            'inaproc.sync',

            // RPJMD
            'rpjmd.view',
            'rpjmd.create',
            'rpjmd.edit',

            // Renstra
            'renstra.view',
            'renstra.create',
            'renstra.edit',

            // Renja
            'renja.view',
            'renja.create',
            'renja.edit',

            // Profile
            'profile.view',
            'profile.edit',
            'password.change',
        ]);


        /*
        |--------------------------------------------------------------------------
        | VIEWER
        |--------------------------------------------------------------------------
        */

        $viewer->syncPermissions([

            // Dashboard
            'dashboard.view',

            // Data Pengadaan - Read Only
            'procurement.view',

            // Dokumen - Read Only
            'procurement-documents.view',

            // Verifikasi - Read Only
            'verification.view',

            // Evaluasi - Read Only
            'evaluations.view',

            // Laporan
            'reports.view',
            'reports.export',

            // Monitoring
            'monitoring.view',

            // Inaproc - Read Only
            'inaproc.view',

            // RPJMD
            'rpjmd.view',

            // Renstra
            'renstra.view',

            // Renja
            'renja.view',

            // Profile
            'profile.view',
            'profile.edit',
            'password.change',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Reset Permission Cache
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}