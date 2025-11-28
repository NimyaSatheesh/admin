<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Clear cache
         app()[PermissionRegistrar::class]->forgetCachedPermissions();

         // CREATE PERMISSIONS

         $permissions = [
             'user.create', 'user.view', 'user.update', 'user.delete',
             'role.create', 'role.view', 'role.update', 'role.delete',
             'content.create', 'content.view', 'content.update', 'content.delete',
             'profile.view', 'profile.update'
         ];
 
         foreach ($permissions as $permission) {
             Permission::firstOrCreate(['name' => $permission,'guard_name' => 'web']);
         }
 
         // CREATE ROLES
         $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
         $admin      = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
         $user       = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
 
         // ASSIGN PERMISSIONS
 
         // ADMIN CAN UPDATE, VIEW, CREATE (BUT NOT DELETE)
         $admin->syncPermissions([
             'user.view','user.update',
 
             'content.create','content.update', 'content.view',
 
             'profile.view','profile.update',
 
             'role.view'
         ]);
 
         // USER CAN ONLY VIEW
         $user->syncPermissions([
             'content.view', 'profile.view',
         ]);
 
         // SUPER ADMIN GETS EVERYTHING
         $superAdmin->syncPermissions(Permission::all());
 
         // Reset cache again
         app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
