<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $sysadmin1 = User::create([
            'username' => 'sys1',
            'is_admin'=>'1',
            'password'=> bcrypt('sys'),
            'User_FullName'=> 'System Administrator 1'
        ]);

        $sysadmin2 = User::create([
            'username' => 'sys2',
            'is_admin'=>'1',
            'password'=> bcrypt('sys'),
            'User_FullName'=> 'System Administrator 2'
        ]);

        $sysadmin3 = User::create([
            'username' => 'sys3',
            'is_admin'=>'1',
            'password'=> bcrypt('sys'),
            'User_FullName'=> 'System Administrator 3'
        ]);
        
    }
}
