<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\AccessControlService;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure default roles exist
        $roles = AccessControlService::ensureDefaultRoles();

        // 2. Seed permissions from routes
        $this->call(SeedPermission::class);

        // 3. Assign super_admin role to the existing admin user
        $adminUser = User::where('username', 'admin')->first();
        if ($adminUser) {
            $adminUser->syncRoles(['super_admin']);
        }

        // 4. Give the admin role some base permissions
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $basicPerms = Permission::whereIn('name', [
                'dashboard.view',
                'users.index',
                'users.create',
                'users.store',
                'users.edit',
                'users.update',
                'roles.index',
                'roles.create',
                'roles.store',
                'roles.edit',
                'roles.update',
                'permissions.index',
            ])->pluck('id')->toArray();
            $adminRole->syncPermissions($basicPerms);
        }

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
