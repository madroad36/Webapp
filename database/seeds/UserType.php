<?php

use Illuminate\Database\Seeder;

class UserType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $usertypes = [
            ['name'=>'admin'],
            ['name'=>'user'],
            ['name'=>'receptionist'],
        ];
        DB::table('usertype')->insert($usertypes);
    }
}
