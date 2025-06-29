<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Execute the php artisan shield:generate --all command
        Artisan::call('shield:generate', ['--all' => true, '--panel' => 'admin']);

        $adminUser = User::where('email', 'like', '%jorge@gmail.com%')->first();

        // Execute the command php artisan shield:super-admin to create the super_admin role
        Artisan::call('shield:super-admin', ['--user' => $adminUser->id]);

        // Get permissions that contain "request" in their name
        $sellerPermissions = Permission::where('name', 'like', '%page%')->orWhere('name', 'like', '%calendar%')->get();
        $adminPermissions = Permission::all();

        $admin = Role::where('name', 'Admin')->first();
        $seller = Role::where('name', 'Seller')->first();

        // Assign permissions to roles
        $admin->syncPermissions($adminPermissions);
        $seller->syncPermissions($sellerPermissions);

        $this->command->info('Roles y permisos creados correctamente.');
    }
}
