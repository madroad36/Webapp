<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            ['name'=>'Add User','slug'=>'add-user'],
            ['name'=>'Edit User','slug'=>'edit-user'],
            ['name'=>'View User','slug'=>'view-user'],
            ['name'=>'Delete User','slug'=>'delete-user'],
            ['name'=>'Add Role','slug'=>'add-role'],
            ['name'=>'Edit Role','slug'=>'edit-role'],
            ['name'=>'View Role','slug'=>'view-role'],
            ['name'=>'Delete Role','slug'=>'delete-role'],
            ['name'=>'Assign Role','slug'=>'assign-role'],
            ['name'=>'Add Permission','slug'=>'add-permission'],
            ['name'=>'Edit Permission','slug'=>'edit-permission'],
            ['name'=>'View Permission','slug'=>'view-permission'],
            ['name'=>'Delete Permission','slug'=>'delete-permission'],
            ['name'=>'Assign Permission','slug'=>'assign-permission'],
            ['name'=>'Add Service','slug'=>'add-service'],
            ['name'=>'Edit Service','slug'=>'edit-service'],
            ['name'=>'View Service','slug'=>'view-service'],
            ['name'=>'Delete Service','slug'=>'delete-service'],
            ['name'=>'Add Setting','slug'=>'add-setting'],
            ['name'=>'Edit Setting','slug'=>'edit-setting'],
            ['name'=>'View Setting','slug'=>'view-setting'],
            ['name'=>'Delete Setting','slug'=>'delete-setting'],
            ['name'=>'Add Product Category','slug'=>'add-product-category'],
            ['name'=>'Edit Product Category','slug'=>'edit-product-category'],
            ['name'=>'View Product Category','slug'=>'view-product-category'],
            ['name'=>'Delete Product Category','slug'=>'delete-product-category'],
            ['name'=>'Add Product ','slug'=>'add-product'],
            ['name'=>'Edit Product ','slug'=>'edit-product'],
            ['name'=>'View Product ','slug'=>'view-product'],
            ['name'=>'Delete Product ','slug'=>'delete-product'],
            ['name'=>'Add Product Image ','slug'=>'add-product-image'],
            ['name'=>'Edit Product Image ','slug'=>'edit-product-image'],
            ['name'=>'View Product Image ','slug'=>'view-product-image'],
            ['name'=>'Delete Product Image ','slug'=>'delete-product-image'],
            ['name'=>'Add Property Category ','slug'=>'add-property-category'],
            ['name'=>'Edit Property Category ','slug'=>'edit-property-category'],
            ['name'=>'View Property Category ','slug'=>'view-property-category'],
            ['name'=>'Delete Property Category ','slug'=>'delete-property-category'],
            ['name'=>'Add Property SubCategory ','slug'=>'add-property-subcategory'],
            ['name'=>'Edit Property SubCategory ','slug'=>'edit-property-subcategory'],
            ['name'=>'View Property SubCategory ','slug'=>'view-property-subcategory'],
            ['name'=>'Delete Property SubCategory ','slug'=>'delete-property-subcategory'],
            ['name'=>'Add Property  ','slug'=>'add-property'],
            ['name'=>'Edit Property  ','slug'=>'edit-property'],
            ['name'=>'View Property  ','slug'=>'view-property'],
            ['name'=>'Delete Property  ','slug'=>'delete-property'],
            ['name'=>'Add Property Image  ','slug'=>'add-property-image'],
            ['name'=>'Edit Property Image  ','slug'=>'edit-property-image'],
            ['name'=>'View Property Image  ','slug'=>'view-property-image'],
            ['name'=>'Delete Property Image  ','slug'=>'delete-property-image'],
        ];

        DB::table('permission')->insert($permission);
    }
}
