<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $category  = [
            ['name'=>'house', 'is_active'=>'1', 'slug'=>'house', 'created_by'=>'1'],
            ['name'=>'land', 'is_active'=>'1', 'slug'=>'land', 'created_by'=>'1'],
        ];
        DB::table('category')->insert($category);
    }
}
