<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::factory()->create(["name"=>"admin"]);
        $editor = Role::factory()->create(["name"=>"editor"]);
        $viewer = Role::factory()->create(["name"=>"viewer"]);

        $permissions = Permission::all();

        $admin->permissions()->attach($permissions->pluck('id'));
        $editor->permissions()->attach($permissions->pluck('id'));
        $editor->permissions()->detach(4);
        $viewer->permissions()->attach([1, 3, 5, 7]);
    }
}
