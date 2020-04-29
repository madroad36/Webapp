<?php

use Illuminate\Database\Seeder;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users  = [
            ['name'=>'superAdmin', 'email'=>'admin@gmail.com', 'password'=>bcrypt('admin'), 'usertype_id'=>'1'],
        ];
        DB::table('users')->insert($users);
    }
}
