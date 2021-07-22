<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // * reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // * Create permission
        Permission::create([
            "name" => "create project"
        ]);
        Permission::create([
            "name" => "edit project"
        ]);
        Permission::create([
            "name" => "delete project"
        ]);
        Permission::create([
            "name" => "delete assigned project"
        ]);
        Permission::create([
            "name" => "create assigned project"
        ]);
        Permission::create([
            "name" => "edit assigned project"
        ]);

        // * create roles and assign existing permissions
        $projectManagerRole = Role::create(['name' => 'project-manager']);
        $projectManagerRole->givePermissionTo(['create project', 'edit project', 'delete project', 'create assigned project', 'delete assigned project', 'edit assigned project']);

        // * create super admin roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // * assign role to user
        $projectManager = User::factory()->create([
            "name" => "project manager",
            "email" => "project.manager@mail.com"
        ]);
        $projectManager->assignRole($projectManagerRole);

        $superAdmin = User::factory()->create([
            "name" => "user-admin",
            "email" => "super.admin@mail.com"
        ]);
        $superAdmin->assignRole($superAdminRole);
        User::factory()->count(10)->create();
    }
}
