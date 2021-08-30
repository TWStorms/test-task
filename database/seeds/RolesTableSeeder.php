<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class RolesTableSeeder
 */
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::findOrCreate('super_admin', 'web');
        Role::findOrCreate('sub_admin', 'web');
        Role::findOrCreate('user', 'web');
    }
}
