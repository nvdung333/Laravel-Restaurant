<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator', // optional
            'description' => 'Quản trị viên', // optional
        ]);
        
        $smod = Role::create([
            'name' => 'smod',
            'display_name' => 'Super Moderator', // optional
            'description' => 'Người điều hành cấp cao', // optional
        ]);

        $mod = Role::create([
            'name' => 'mod',
            'display_name' => 'Moderator', // optional
            'description' => 'Người điều hành', // optional
        ]);
        
    }
}
