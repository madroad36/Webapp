<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
          ['name'=>'Teacher',           'slug'=>'teacher'],
          ['name'=>'Accountain',        'slug'=>'accountain'],
          ['name'=>'Receopnist',        'slug'=>'receopnist'],
          ['name'=>'Student',           'slug'=>'student'],
          ['name'=>'Staff',             'slug'=>'Staff'],

      ];

      DB::table('roles')->insert($roles);
  }
}
