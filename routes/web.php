<?php
use App\Models\Setting; 

Auth::routes(['register' => false, 'login'=>false]);

Route::get('/',                 ['uses'=>'HomeController@index',            'as'=>'home']);
Route::post('/register/store',  ['uses'=>'HomeController@store',            'as'=>'register.store']);
Route::get('/register',         ['uses'=>'Auth\RegisterController@index',   'as'=>'register.index']);

// Password Reset
Route::get('/forget_password',  ['uses'=>'Auth\AdminPasswordController@passwordreset',    'as'=>'forgetpassword']);
Route::post('/send_link',       ['uses'=>'Auth\AdminPasswordController@sendlink',         'as'=>'sendlink']);
Route::post('/storepassword',   ['uses'=>'Auth\AdminPasswordController@storepassword',    'as'=>'storepassword']);
Route::get('/getlink/{token}',  ['uses'=>'Auth\AdminPasswordController@getlink',          'as'=>'link']);

//Login Section

Route::group(['prefix' => 'admin', 'namespace' => 'Auth', 'middleware' => 'web'], function (){

    Route::get('/login',            ['uses'=>'AdminController@showLoginForm',       'as'=>'admin.login'])->middleware('guest');
    Route::post('/login',           ['uses'=>'AdminController@login',               'as'=>'admin.login']);
    Route::get('/dashboard',        ['uses'=>'AdminController@dashboard',           'as'=>'admin.dashboard'])->middleware('admin');
    Route::get('/logout',           ['uses'=>'AdminController@logout',              'as'=>'admin.logout']);

}); 


Route::group(['prefix'=>'admin', 'namespace'=>'Admin','middleware'=>['web','admin']],function(){

    //UserType Section
    Route::get('/users_type',                   ['uses'=>'UserTypeController@index',       'as'=>'admin.users_type.index']);
    Route::get('/users_type/create',            ['uses'=>'UserTypeController@create',      'as'=>'admin.users_type.create']);
    Route::post('/users_type/store',            ['uses'=>'UserTypeController@store',       'as'=>'admin.users_type.store']);
    Route::get('/users_type/edit/{id}',         ['uses'=>'UserTypeController@edit',        'as'=>'admin.users_type.edit']);
    Route::post('/users_type/update/{id}',      ['uses'=>'UserTypeController@update',      'as'=>'admin.users_type.update']);
    Route::delete('/users_type/delete/{id}',    ['uses'=>'UserTypeController@destroy',     'as'=>'admin.users_type.delete']);
    Route::get('/users_type/getdata',           ['uses'=>'UserTypeController@getdata',     'as'=>'admin.users_type.getdata']);


    //User Section
    Route::get('/users',                        ['uses'=>'UserController@index',            'as'=>'admin.users.index']);
    Route::get('/users/create',                 ['uses'=>'UserController@create',           'as'=>'admin.users.create']);
    Route::post('/users/store',                 ['uses'=>'UserController@store',            'as'=>'admin.users.store']);
    Route::get('/users/edit/{id}',              ['uses'=>'UserController@edit',             'as'=>'admin.users.edit']);
    Route::post('/users/update/{id}',           ['uses'=>'UserController@update',           'as'=>'admin.users.update']);
    Route::delete('/users/delete/{id}',         ['uses'=>'UserController@destroy',          'as'=>'admin.users.delete']);
    Route::get('/users/getdata',                ['uses'=>'UserController@getdata',          'as'=>'admin.users.getdata']);
    Route::post('/users/change-status',         ['uses'=>'UserController@changeStatus',     'as'=>'admin.users.change-status']);
    Route::get('/users/show/{slug}',            ['uses'=>'UserController@show',             'as'=>'admin.users.show']);
    Route::post('/users/broker',                ['uses'=>'UserController@broker',           'as'=>'admin.users.broker']);
    Route::post('/users/service',               ['uses'=>'UserController@service',          'as'=>'admin.users.service']);
    Route::post('/users/vendor',                ['uses'=>'UserController@vendor',           'as'=>'admin.users.vendor']);

    //Borker Section
    Route::get('/broker',                       ['uses'=>'BrokerController@index',          'as'=>'admin.broker.index']);
    Route::get('/broker/getdata',               ['uses'=>'BrokerController@getdata',        'as'=>'admin.broker.getdata']);
    Route::post('/broker/change-status',        ['uses'=>'BrokerController@changeStatus',   'as'=>'admin.broker.change-status']);

    
    //Vendor    
    Route::get('/vendor',                       ['uses'=>'VendorController@index',          'as'=>'admin.vendor.index']);
    Route::get('/vendor/getdata',               ['uses'=>'VendorController@getdata',        'as'=>'admin.vendor.getdata']);
    Route::post('/vendor/change-status',        ['uses'=>'VendorController@changeStatus',   'as'=>'admin.vendor.change-status']);

    //Technician
    Route::get('/technician',                   ['uses'=>'TechnicianController@index',          'as'=>'admin.technician.index']);
    Route::get('/technician/getdata',           ['uses'=>'TechnicianController@getdata',        'as'=>'admin.technician.getdata']);
    Route::post('/technician/change-status',    ['uses'=>'TechnicianController@changeStatus',   'as'=>'admin.technician.change-status']);



    // Contact
    Route::get('/contact',                      ['uses'=>'ContactController@index',         'as'=>'admin.contact.index']);
    Route::get('/contact/create',               ['uses'=>'ContactController@create',        'as'=>'admin.contact.create']);
    Route::post('/contact/store',               ['uses'=>'ContactController@store',         'as'=>'admin.contact.store']);
    Route::get('/contact/edit/{id}',            ['uses'=>'ContactController@edit',          'as'=>'admin.contact.edit']);
    Route::post('/contact/update/{id}',         ['uses'=>'ContactController@update',        'as'=>'admin.contact.update']);
    Route::delete('/contact/delete/{id}',       ['uses'=>'ContactController@destroy',       'as'=>'admin.contact.delete']);
    Route::get('/contact/getdata',              ['uses'=>'ContactController@getdata',       'as'=>'admin.contact.getdata']);
    Route::post('/contact/change-status',       ['uses'=>'ContactController@changeStatus',  'as'=>'admin.contact.change-status']);

    //User Role
    Route::get('/user-role',                    ['uses'=>'UserRoleController@index',        'as'=>'admin.userRole.index']);
    Route::get('/user-role/create',             ['uses'=>'UserRoleController@create',       'as'=>'admin.userRole.create']);
    Route::post('/user-role/store',             ['uses'=>'UserRoleController@store',        'as'=>'admin.userRole.store']);
    Route::get('/get-role/{id}',                ['uses'=>'UserRoleController@getRole',      'as'=>'admin.userRole.get']);

    //Roles
    Route::get('/role',                         ['uses'=>'RoleController@index',            'as'=>'admin.role.index']);
    Route::get('/role/create',                  ['uses'=>'RoleController@create',           'as'=>'admin.role.create']);
    Route::post('/role/store',                  ['uses'=>'RoleController@store',            'as'=>'admin.role.store']);
    Route::get('/role/edit/{id}',               ['uses'=>'RoleController@edit',             'as'=>'admin.role.edit']);
    Route::post('/role/update/{id}',            ['uses'=>'RoleController@update',           'as'=>'admin.role.update']);
    Route::delete('/role/delete/{id}',          ['uses'=>'RoleController@destroy',          'as'=>'admin.role.delete']);

    //Permission
    Route::post('/permissionstore',             ['uses'=>'RoleController@storepermission',        'as'=>'admin.role.permissionstore']);
    Route::get('/getpermission',                ['uses'=>'RoleController@getpermission',          'as'=>'admin.role.getpermission']);
    Route::get('/role/get-permission/{id}',     ['uses'=>'RoleController@getrolepermission',      'as'=>'admin.role.get-permission']);
    Route::get('/role/getdata',                 ['uses'=>'RoleController@getdata',                'as'=>'admin.role.getdata']);
    Route::post('/role/change-status',          ['uses'=>'RoleController@changeStatus',           'as'=>'admin.role.change-status']);


    // permission route
    Route::get('/permission',                   ['uses'=>'PermissionController@index',          'as'=>'admin.permission.index']);
    Route::get('/permission/create',            ['uses'=>'PermissionController@create',         'as'=>'admin.permission.create']);
    Route::post('/permission/store',            ['uses'=>'PermissionController@store',          'as'=>'admin.permission.store']);
    Route::get('/permission/edit/{id}',         ['uses'=>'PermissionController@edit',           'as'=>'admin.permission.edit']);
    Route::post('/permission/update/{id}',      ['uses'=>'PermissionController@update',         'as'=>'admin.permission.update']);
    Route::delete('/permission/delete/{id}',    ['uses'=>'PermissionController@destroy',        'as'=>'admin.permission.delete']);
    Route::get('/permission/getdata',           ['uses'=>'PermissionController@getdata',        'as'=>'admin.permission.getdata']);
    Route::post('/permission/change-status',    ['uses'=>'PermissionController@changeStatus',   'as'=>'admin.permission.change-status']);

    // location route
    Route::get('/location',                     ['uses'=>'LocationController@index',            'as'=>'admin.location.index']);
    Route::get('/location/create',              ['uses'=>'LocationController@create',           'as'=>'admin.location.create']);
    Route::post('/location/store',              ['uses'=>'LocationController@store',            'as'=>'admin.location.store']);
    Route::get('/location/edit/{id}',           ['uses'=>'LocationController@edit',             'as'=>'admin.location.edit']);
    Route::post('/location/update/{id}',        ['uses'=>'LocationController@update',           'as'=>'admin.location.update']);
    Route::delete('/location/delete/{id}',      ['uses'=>'LocationController@destroy',          'as'=>'admin.location.delete']);
    Route::get('/location/getdata',             ['uses'=>'LocationController@getdata',          'as'=>'admin.location.getdata']);
    Route::post('/location/change-status',      ['uses'=>'LocationController@changeStatus',     'as'=>'admin.location.change-status']);

    //Location Place
    Route::get('/place',                        ['uses'=>'PlaceController@index',               'as'=>'admin.place.index']);
    Route::get('/place/create',                 ['uses'=>'PlaceController@create',              'as'=>'admin.place.create']);
    Route::post('/place/store',                 ['uses'=>'PlaceController@store',               'as'=>'admin.place.store']);
    Route::get('/place/edit/{id}',              ['uses'=>'PlaceController@edit',                'as'=>'admin.place.edit']);
    Route::post('/place/update/{id}',           ['uses'=>'PlaceController@update',              'as'=>'admin.place.update']);
    Route::delete('/place/delete/{id}',         ['uses'=>'PlaceController@destroy',             'as'=>'admin.place.delete']);
    Route::get('/place/getdata',                ['uses'=>'PlaceController@getdata',             'as'=>'admin.place.getdata']);
    Route::post('/place/change-status',         ['uses'=>'PlaceController@changeStatus',        'as'=>'admin.place.change-status']);


    //  Category route
    Route::get('/category',                     ['uses'=>'CategoryController@index',            'as'=>'admin.category.index']);
    Route::get('/category/create',              ['uses'=>'CategoryController@create',           'as'=>'admin.category.create']);
    Route::post('/category/store',              ['uses'=>'CategoryController@store',            'as'=>'admin.category.store']);
    Route::get('/category/edit/{id}',           ['uses'=>'CategoryController@edit',             'as'=>'admin.category.edit']);
    Route::post('/category/update/{id}',        ['uses'=>'CategoryController@update',           'as'=>'admin.category.update']);
    Route::delete('/category/delete/{id}',      ['uses'=>'CategoryController@destroy',          'as'=>'admin.category.delete']);
    Route::get('/category/getdata',             ['uses'=>'CategoryController@getdata',          'as'=>'admin.category.getdata']);
    Route::post('/category/change-status',      ['uses'=>'CategoryController@changeStatus',     'as'=>'admin.category.change-status']);


    //Aminitites
    Route::get('/aminities',                    ['uses'=>'AminitiesController@index',           'as'=>'admin.aminities.index']);
    Route::get('/aminities/create',             ['uses'=>'AminitiesController@create',          'as'=>'admin.aminities.create']);
    Route::post('/aminities/store',             ['uses'=>'AminitiesController@store',           'as'=>'admin.aminities.store']);
    Route::get('/aminities/edit/{id}',          ['uses'=>'AminitiesController@edit',            'as'=>'admin.aminities.edit']);
    Route::post('/aminities/update/{id}',       ['uses'=>'AminitiesController@update',          'as'=>'admin.aminities.update']);
    Route::delete('/aminities/delete/{id}',     ['uses'=>'AminitiesController@destroy',         'as'=>'admin.aminities.delete']);
    Route::get('/aminities/getdata',            ['uses'=>'AminitiesController@getdata',         'as'=>'admin.aminities.getdata']);
    Route::post('/aminities/change-status',     ['uses'=>'AminitiesController@changeStatus',    'as'=>'admin.aminities.change-status']); 


    //Advertisement
    Route::get('/advertisement',                    ['uses'=>'AdvertisementController@index',           'as'=>'admin.advertisement.index']);
    Route::get('/advertisement/create',             ['uses'=>'AdvertisementController@create',          'as'=>'admin.advertisement.create']);
    Route::post('/advertisement/store',             ['uses'=>'AdvertisementController@store',           'as'=>'admin.advertisement.store']);
    Route::get('/advertisement/edit/{id}',          ['uses'=>'AdvertisementController@edit',            'as'=>'admin.advertisement.edit']);
    Route::post('/advertisement/update/{id}',       ['uses'=>'AdvertisementController@update',          'as'=>'admin.advertisement.update']);
    Route::delete('/advertisement/delete/{id}',     ['uses'=>'AdvertisementController@destroy',         'as'=>'admin.advertisement.delete']);
    Route::get('/advertisement/getdata',            ['uses'=>'AdvertisementController@getdata',         'as'=>'admin.advertisement.getdata']);
    Route::post('/advertisement/change-status',     ['uses'=>'AdvertisementController@changeStatus',    'as'=>'admin.advertisement.change-status']); 

    //Slider
    Route::get('/slider',                    ['uses'=>'SliderController@index',           'as'=>'admin.slider.index']);
    Route::get('/slider/create',             ['uses'=>'SliderController@create',          'as'=>'admin.slider.create']);
    Route::post('/slider/store',             ['uses'=>'SliderController@store',           'as'=>'admin.slider.store']);
    Route::get('/slider/edit/{id}',          ['uses'=>'SliderController@edit',            'as'=>'admin.slider.edit']);
    Route::post('/slider/update/{id}',       ['uses'=>'SliderController@update',          'as'=>'admin.slider.update']);
    Route::delete('/slider/delete/{id}',     ['uses'=>'SliderController@destroy',         'as'=>'admin.slider.delete']);
    Route::get('/slider/getdata',            ['uses'=>'SliderController@getdata',         'as'=>'admin.slider.getdata']);
    Route::post('/slider/change-status',     ['uses'=>'SliderController@changeStatus',    'as'=>'admin.slider.change-status']);



    // subcategory route
    Route::get('/subcategory',                  ['uses'=>'SubCategoryController@index',         'as'=>'admin.subcategory.index']);
    Route::get('/subcategory/create',           ['uses'=>'SubCategoryController@create',        'as'=>'admin.subcategory.create']);
    Route::post('/subcategory/store',           ['uses'=>'SubCategoryController@store',         'as'=>'admin.subcategory.store']);
    Route::get('/subcategory/edit/{id}',        ['uses'=>'SubCategoryController@edit',          'as'=>'admin.subcategory.edit']);
    Route::post('/subcategory/update/{id}',     ['uses'=>'SubCategoryController@update',        'as'=>'admin.subcategory.update']);
    Route::delete('/subcategory/delete/{id}',   ['uses'=>'SubCategoryController@destroy',       'as'=>'admin.subcategory.delete']);
    Route::get('/subcategory/getdata',          ['uses'=>'SubCategoryController@getdata',       'as'=>'admin.subcategory.getdata']);
    Route::post('/subcategory/change-status',   ['uses'=>'SubCategoryController@changeStatus',  'as'=>'admin.subcategory.change-status']);


    //Property Booking
    Route::get('/property-booking',             ['uses'=>'PropertyBookingController@index',         'as'=>'admin.booking.index']);
    Route::get('/property-booking/getbooking',  ['uses'=>'PropertyBookingController@getbooking',    'as'=>'admin.booking.getbooking']);
    Route::post('/booking/change-status',       ['uses'=>'PropertyBookingController@changeStatus',  'as'=>'admin.booking.change-status']);




    //Property
    Route::get('/property',                     ['uses'=>'PropertyController@index',                'as'=>'admin.property.index']);
    Route::get('/property/create',              ['uses'=>'PropertyController@create',               'as'=>'admin.property.create']);
    Route::post('/property/store',              ['uses'=>'PropertyController@store',                'as'=>'admin.property.store']);
    Route::get('/property/edit/{id}',           ['uses'=>'PropertyController@edit',                 'as'=>'admin.property.edit']);
    Route::post('/property/update/{id}',        ['uses'=>'PropertyController@update',               'as'=>'admin.property.update']);
    Route::delete('/property/delete/{id}',      ['uses'=>'PropertyController@destroy',              'as'=>'admin.property.delete']);
    Route::get('/property/getdata',             ['uses'=>'PropertyController@getdata',              'as'=>'admin.property.getdata']);
    Route::post('/property/change-status',      ['uses'=>'PropertyController@changeStatus',         'as'=>'admin.property.change-status']);
    Route::get('/property/getsubcategory',      ['uses'=>'PropertyController@getsubcategory',       'as'=>'admin.property.getsubcategory']);
    Route::post('/property/sold',               ['uses'=>'PropertyController@sold',                 'as'=>'admin.property.sold']);
    Route::post('/property/paid',               ['uses'=>'PropertyController@paid',                 'as'=>'admin.property.paid']);
    Route::get('/property/getusertype',         ['uses'=>'PropertyController@getusertype',          'as'=>'admin.property.getusertype']);
    Route::get('/property/getuser',             ['uses'=>'PropertyController@getuser',              'as'=>'admin.property.getuser']);
    Route::get('/property/getplace',            ['uses'=>'PropertyController@getplace',             'as'=>'admin.property.getplace']);
    Route::post('property/assignUsertype',      ['uses'=>'PropertyController@assignUsertype',       'as'=>'admin.property.assignUsertype']);

    //Property Image
    Route::get('/property_image/{id}',              ['uses'=>'PropertyImageController@index',       'as'=>'admin.property_image.index']);
    Route::get('/property_image/create/{id}',       ['uses'=>'PropertyImageController@create',      'as'=>'admin.property_image.create']);
    Route::post('/property_image/store/{id}',       ['uses'=>'PropertyImageController@store',       'as'=>'admin.property_image.store']);
    Route::delete('/property_image/delete/{id}',    ['uses'=>'PropertyImageController@destroy',     'as'=>'admin.property_image.delete']);

    //Service Category
    Route::get('/service_category',                 ['uses'=>'ServiceCategoryController@index',         'as'=>'admin.service_category.index']);
    Route::get('/service_category/create',          ['uses'=>'ServiceCategoryController@create',        'as'=>'admin.service_category.create']);
    Route::post('/service_category/store',          ['uses'=>'ServiceCategoryController@store',         'as'=>'admin.service_category.store']);
    Route::get('/service_category/edit/{id}',       ['uses'=>'ServiceCategoryController@edit',          'as'=>'admin.service_category.edit']);
    Route::post('/service_category/update/{id}',    ['uses'=>'ServiceCategoryController@update',        'as'=>'admin.service_category.update']);
    Route::delete('/service_category/delete/{id}',  ['uses'=>'ServiceCategoryController@destroy',       'as'=>'admin.service_category.delete']);
    Route::get('/service_category/getdata',         ['uses'=>'ServiceCategoryController@getdata',       'as'=>'admin.service_category.getdata']);
    Route::post('/service_category/change-status',  ['uses'=>'ServiceCategoryController@changeStatus',  'as'=>'admin.service_category.change-status']);

    //Service Sub Category
    Route::get('/service_sub_category',                 ['uses'=>'ServiceSubCategoryController@index',          'as'=>'admin.service_sub_category.index']);
    Route::get('/service_sub_category/create',          ['uses'=>'ServiceSubCategoryController@create',         'as'=>'admin.service_sub_category.create']);
    Route::post('/service_sub_category/store',          ['uses'=>'ServiceSubCategoryController@store',          'as'=>'admin.service_sub_category.store']);
    Route::get('/service_sub_category/edit/{id}',       ['uses'=>'ServiceSubCategoryController@edit',           'as'=>'admin.service_sub_category.edit']);
    Route::post('/service_sub_category/update/{id}',    ['uses'=>'ServiceSubCategoryController@update',         'as'=>'admin.service_sub_category.update']);
    Route::delete('/service_sub_category/delete/{id}',  ['uses'=>'ServiceSubCategoryController@destroy',        'as'=>'admin.service_sub_category.delete']);
    Route::get('/service_sub_category/getdata',         ['uses'=>'ServiceSubCategoryController@getdata',        'as'=>'admin.service_sub_category.getdata']);
    Route::post('/service_sub_category/change-status',  ['uses'=>'ServiceSubCategoryController@changeStatus',   'as'=>'admin.service_sub_category.change-status']);


    //Services
    Route::get('/service',                          ['uses'=>'ServiceController@index',             'as'=>'admin.service.index']);
    Route::get('/service/create',                   ['uses'=>'ServiceController@create',            'as'=>'admin.service.create']);
    Route::post('/service/store',                   ['uses'=>'ServiceController@store',             'as'=>'admin.service.store']);
    Route::get('/service/edit/{id}',                ['uses'=>'ServiceController@edit',              'as'=>'admin.service.edit']);
    Route::post('/service/update/{id}',             ['uses'=>'ServiceController@update',            'as'=>'admin.service.update']);
    Route::delete('/service/delete/{id}',           ['uses'=>'ServiceController@destroy',           'as'=>'admin.service.delete']);
    Route::get('/service/getdata',                  ['uses'=>'ServiceController@getdata',           'as'=>'admin.service.getdata']);
    Route::post('/service/change-status',           ['uses'=>'ServiceController@changeStatus',      'as'=>'admin.service.change-status']);
    Route::get('/service/getsubcategory',           ['uses'=>'ServiceController@getsubcategory',    'as'=>'admin.service.getsubcategory']);


    //product Category
    Route::get('/product_category',                 ['uses'=>'ProductCategoryController@index',            'as'=>'admin.product_category.index']);
    Route::get('/product_category/create',          ['uses'=>'ProductCategoryController@create',           'as'=>'admin.product_category.create']);
    Route::post('/product_category/store',          ['uses'=>'ProductCategoryController@store',            'as'=>'admin.product_category.store']);
    Route::get('/product_category/edit/{id}',       ['uses'=>'ProductCategoryController@edit',             'as'=>'admin.product_category.edit']);
    Route::post('/product_category/update/{id}',    ['uses'=>'ProductCategoryController@update',           'as'=>'admin.product_category.update']);
    Route::delete('/product_category/delete/{id}',  ['uses'=>'ProductCategoryController@destroy',          'as'=>'admin.product_category.delete']);
    Route::get('/product_category/getdata',         ['uses'=>'ProductCategoryController@getdata',          'as'=>'admin.product_category.getdata']);
    Route::post('/product_category/change-status',  ['uses'=>'ProductCategoryController@changeStatus',     'as'=>'admin.product_category.change-status']);


    //Product
    Route::get('/product',                          ['uses'=>'ProductController@index',                 'as'=>'admin.product.index']);
    Route::get('/product/create',                   ['uses'=>'ProductController@create',                'as'=>'admin.product.create']);
    Route::post('/product/store',                   ['uses'=>'ProductController@store',                 'as'=>'admin.product.store']);
    Route::get('/product/edit/{id}',                ['uses'=>'ProductController@edit',                  'as'=>'admin.product.edit']);
    Route::post('/product/update/{id}',             ['uses'=>'ProductController@update',                'as'=>'admin.product.update']);
    Route::delete('/product/delete/{id}',           ['uses'=>'ProductController@destroy',               'as'=>'admin.product.delete']);
    Route::get('/product/getdata',                  ['uses'=>'ProductController@getdata',               'as'=>'admin.product.getdata']);
    Route::post('/product/change-status',           ['uses'=>'ProductController@changeStatus',          'as'=>'admin.product.change-status']);
    Route::post('/product/paid',                    ['uses'=>'ProductController@paid',                  'as'=>'admin.product.paid']);


    //Product Image
    Route::get('/product_image/{id}',               ['uses'=>'ProductImageController@index',            'as'=>'admin.product_image.index']);
    Route::get('/product_image/create/{id}',        ['uses'=>'ProductImageController@create',           'as'=>'admin.product_image.create']);
    Route::post('/product_image/store/{id}',        ['uses'=>'ProductImageController@store',            'as'=>'admin.product_image.store']);
    Route::delete('/product_image/delete/{id}',     ['uses'=>'ProductImageController@destroy',          'as'=>'admin.product_image.delete']);

    Route::get('product/order',                     ['uses'=>'ProductOrderController@index',            'as'=>'admin.product.order']);
    Route::get('order/show/{id}',                   ['uses'=>'ProductOrderController@show',             'as'=>'admin.order.show']);
    Route::get('product/order/getdata',             ['uses'=>'ProductOrderController@getdata',          'as'=>'admin.order.getdata']);
    Route::post('product/order/change-status',      ['uses'=>'ProductOrderController@changeStatus',    'as'=>'admin.order.change-status']);

    // Setting route
    Route::get('/setting',                          ['uses'=>'SettingController@index',                 'as'=>'admin.setting.index']);
    Route::get('/setting/create',                   ['uses'=>'SettingController@create',                'as'=>'admin.setting.create']); 
    Route::post('/setting/store',                   ['uses'=>'SettingController@store',                 'as'=>'admin.setting.store']);
    Route::get('/setting/edit/{id}',                ['uses'=>'SettingController@edit',                  'as'=>'admin.setting.edit']);
    Route::post('/setting/update/{id}',             ['uses'=>'SettingController@update',                'as'=>'admin.setting.update']);
    Route::delete('/setting/delete/{id}',           ['uses'=>'SettingController@destroy',               'as'=>'admin.setting.delete']);
    Route::get('/setting/getdata',                  ['uses'=>'SettingController@getdata',               'as'=>'admin.setting.getdata']);
    Route::post('/setting/change-status',           ['uses'=>'SettingController@changeStatus',          'as'=>'admin.setting.change-status']);

    //service request route//
    Route::get('/servicerequest',                           ['uses'=>'ServiceRequestController@index',              'as'=>'admin.servicerequest.index']);
    Route::get('/servicerequest/create',                    ['uses'=>'ServiceRequestController@create',             'as'=>'admin.servicerequest.create']);
    Route::post('/servicerequest/store',                    ['uses'=>'ServiceRequestController@store',              'as'=>'admin.servicerequest.store']);
    Route::get('/servicerequest/edit/{id}',                 ['uses'=>'ServiceRequestController@edit',               'as'=>'admin.servicerequest.edit']);
    Route::get('/servicerequest/show/{id}',                 ['uses'=>'ServiceRequestController@show',               'as'=>'admin.servicerequest.show']);
    Route::post('/servicerequest/update/{id}',              ['uses'=>'ServiceRequestController@update',             'as'=>'admin.servicerequest.update']);
    Route::delete('/servicerequest/delete/{id}',            ['uses'=>'ServiceRequestController@destroy',            'as'=>'admin.servicerequest.delete']);
    Route::get('/servicerequest/getdata',                   ['uses'=>'ServiceRequestController@getdata',            'as'=>'admin.servicerequest.getdata']);
    Route::post('/servicerequest/change-status',            ['uses'=>'ServiceRequestController@changeStatus',       'as'=>'admin.servicerequest.change-status']);
    Route::post('admin/servicerequest/assignTechnician',    ['uses'=>'ServiceRequestController@assignTechnician',   'as'=>'admin.servicerequest.assignTechnician']);


    Route::get('/skill/getcategory/{id}',                   ['uses'=>'SkillController@getcategory',                 'as'=>'admin.skill.getcategory']);
    
    // admin notification
    Route::get('admin/notification',                        ['uses'=>'NotificationController@index',                'as'=>'admin.notification.index']);
    Route::post('admin/notification/change-status',         ['uses'=>'NotificationController@changeStatus',         'as'=>'admin.notification.change-status']);

});

Route::get('/login',            ['uses'=>'Auth\LoginController@showLoginForm',      'as'=>'login']);
Route::post('/login',           ['uses'=>'Auth\LoginController@login',              'as'=>'login']);
Route::get('/logout',           ['uses'=>'Auth\LoginController@logout',             'as'=>'logout']);




// user
Route::get('/users',                    ['uses'=>'UserController@index',        'as'=>'users.index'])->middleware('permission:view-user');
Route::get('/users/create',             ['uses'=>'UserController@create',       'as'=>'users.create'])->middleware('permission:add-user');
Route::post('/users/store',             ['uses'=>'UserController@store',        'as'=>'users.store'])->middleware('permission:add-user');
Route::get('/users/edit/{id}',          ['uses'=>'UserController@edit',         'as'=>'users.edit'])->middleware('permission:edit-user');
Route::post('/users/update/{id}',       ['uses'=>'UserController@update',       'as'=>'users.update'])->middleware('permission:edit-user');
Route::delete('/users/delete/{id}',     ['uses'=>'UserController@destroy',      'as'=>'users.delete'])->middleware('permission:delete-user');
Route::get('/users/getdata',            ['uses'=>'UserController@getdata',      'as'=>'users.getdata'])->middleware('permission:add-view');
Route::post('/users/change-status',     ['uses'=>'UserController@changeStatus', 'as'=>'users.change-status'])->middleware('permission:add-view');





// Role

Route::get('/role',                 ['uses'=>'RoleController@index',        'as'=>'role.index'])->middleware('permission:add-role');
Route::get('/role/create',          ['uses'=>'RoleController@create',       'as'=>'role.create'])->middleware('permission:add-role');
Route::get('/role/store',           ['uses'=>'RoleController@store',        'as'=>'role.store'])->middleware('permission:add-role');
Route::get('/role/edit/{id}',       ['uses'=>'RoleController@edit',         'as'=>'role.edit'])->middleware('permission:edit-role');
Route::get('/role/update/{id}',     ['uses'=>'RoleController@update',       'as'=>'role.update'])->middleware('permission:edit-role');
Route::get('/role/delete/{id}',     ['uses'=>'RoleController@destroy',      'as'=>'role.delete'])->middleware('permission:delete-role');
Route::get('/role/getdata',         ['uses'=>'RoleController@getdata',      'as'=>'role.getdata'])->middleware('permission:view-role');


// Permsission
Route::get('/permission',           ['uses'=>'PermissionController@index',      'as'=>'permission.index'])->middleware('permission:view-permission');
Route::get('/permission/getdata',   ['uses'=>'PermissionController@getdata',    'as'=>'permission.getdata'])->middleware('permission:view-permission');

// userRole
Route::get('/user-role',            ['uses'=>'UserRoleController@index',        'as'=>'userRole.index'])->middleware('permission:view-user');
Route::get('/user-role/create',     ['uses'=>'UserRoleController@create',       'as'=>'userRole.create'])->middleware('permission:add-user');
Route::post('/user-role/store',     ['uses'=>'UserRoleController@store',        'as'=>'userRole.store'])->middleware('permission:add-user');
Route::get('/get-role/{id}',        ['uses'=>'UserRoleController@getRole',      'as'=>'userRole.get'])->middleware('permission:assign-role');

//RolePermission
Route::get('/role-permission',              ['uses'=>'RolePermissionController@index',          'as'=>'rolePermission.index'])->middleware('permission:assign-category');
Route::get('/role-permission/create',       ['uses'=>'RolePermissionController@create',         'as'=>'rolePermission.create'])->middleware('permission:assign-permission');
Route::post('/role-permission/store',       ['uses'=>'RolePermissionController@store',          'as'=>'rolePermission.store'])->middleware('permission:assign-permission');
Route::get('/get-permission/{id}',          ['uses'=>'RolePermissionController@getPermission',  'as'=>'rolePermission.get'])->middleware('permission:assign-permission');



//class
Route::group(['prefix'=>'auth','namespace'=>'Auth','middleware'=>'auth'],function(){
    Route::get('/home',                         ['uses'=>'HomeController@index',                'as'=>'auth.home']);

    //Profile
    Route::get('/profile',                      ['uses'=>'ProfileController@index',             'as'=>'profile.index']);
    Route::post('/profile/image',               ['uses'=>'ProfileController@uploadImage',       'as'=>'profile.image']);
    Route::post('/profile/nationalId',          ['uses'=>'ProfileController@uploadnationalId',  'as'=>'profile.nationalId']);
    Route::post('/profile/update/{id}',         ['uses'=>'ProfileController@update',            'as'=>'profile.update']);


    //Category
    Route::get('/category',                     ['uses'=>'CategoryController@index',            'as'=>'category.index'])->middleware('permission:view-category');
    Route::get('/category/create',              ['uses'=>'CategoryController@create',           'as'=>'category.create'])->middleware('permission:add-category');
    Route::post('/category/store',              ['uses'=>'CategoryController@store',            'as'=>'category.store'])->middleware('permission:add-category');
    Route::get('/category/edit/{id}',           ['uses'=>'CategoryController@edit',             'as'=>'category.edit'])->middleware('permission:edit-category');
    Route::post('/category/update/{id}',        ['uses'=>'CategoryController@update',           'as'=>'category.update'])->middleware('permission:edit-category');
    Route::delete('/category/delete/{id}',      ['uses'=>'CategoryController@destroy',          'as'=>'category.delete'])->middleware('permission:delete-category');
    Route::get('/category/getdata',             ['uses'=>'CategoryController@getdata',          'as'=>'category.getdata'])->middleware('permission:view-category');
    Route::post('/category/change-status',      ['uses'=>'CategoryController@changeStatus',     'as'=>'category.change-status'])->middleware('permission:ChangeStatus-category');

    //Setting
    Route::get('/setting',                      ['uses'=>'SettingController@index',             'as'=>'setting.index'])->middleware('permission:view-setting');
    Route::get('/setting/create',               ['uses'=>'SettingController@create',            'as'=>'setting.create'])->middleware('permission:add-setting');
    Route::post('/setting/store',               ['uses'=>'SettingController@store',             'as'=>'setting.store'])->middleware('permission:add-setting');
    Route::get('/setting/edit/{id}',            ['uses'=>'SettingController@edit',              'as'=>'setting.edit'])->middleware('permission:edit-setting');
    Route::post('/setting/update/{id}',         ['uses'=>'SettingController@update',            'as'=>'setting.update'])->middleware('permission:edit-setting');
    Route::delete('/setting/delete/{id}',       ['uses'=>'SettingController@destroy',           'as'=>'setting.delete'])->middleware('permission:delete-setting');
    Route::get('/setting/getdata',              ['uses'=>'SettingController@getdata',           'as'=>'setting.getdata'])->middleware('permission:view-setting');
    Route::post('/setting/change-status',       ['uses'=>'SettingController@changeStatus',      'as'=>'setting.change-status'])->middleware('permission:changestatus-setting');


    // Service Caservicerequest/detailstegory
    Route::get('/service_category',                     ['uses'=>'ServiceSubcategoryController@index',          'as'=>'auth.service_category.index'])->middleware('permission:view-service-category');
    Route::get('/service_category/create',              ['uses'=>'ServiceSubcategoryController@create',         'as'=>'auth.service_category.create'])->middleware('permission:add-service-category');
    Route::post('/service_category/store',              ['uses'=>'ServiceSubcategoryController@store',          'as'=>'auth.service_category.store'])->middleware('permission:add-service-category');
    Route::get('/service_category/edit/{id}',           ['uses'=>'ServiceSubcategoryController@edit',           'as'=>'auth.service_category.edit'])->middleware('permission:edit-service-category');
    Route::post('/service_category/update/{id}',        ['uses'=>'ServiceSubcategoryController@update',         'as'=>'auth.service_category.update'])->middleware('permission:edit-service-category');
    Route::delete('/service_category/delete/{id}',      ['uses'=>'ServiceSubcategoryController@destroy',        'as'=>'auth.service_category.delete'])->middleware('permission:delete-service-category');
    Route::get('/service_category/getdata',             ['uses'=>'ServiceSubcategoryController@getdata',        'as'=>'auth.service_category.getdata'])->middleware('permission:view-service-category');
    Route::post('/service_category/change-status',      ['uses'=>'ServiceSubcategoryController@changeStatus',   'as'=>'auth.service_category.change-status'])->middleware('permission:ChangeStatus-service-category');


    //Service
    Route::get('/service',                      ['uses'=>'ServiceController@index',             'as'=>'auth.service.index'])->middleware('permission:view-service');
    Route::get('/service/create',               ['uses'=>'ServiceController@create',            'as'=>'auth.service.create'])->middleware('permission:add-service');
    Route::post('/service/store',               ['uses'=>'ServiceController@store',             'as'=>'auth.service.store'])->middleware('permission:add-service');
    Route::get('/service/edit/{id}',            ['uses'=>'ServiceController@edit',              'as'=>'auth.service.edit'])->middleware('permission:edit-service');
    Route::post('/service/update/{id}',         ['uses'=>'ServiceController@update',            'as'=>'auth.service.update'])->middleware('permission:edit-service');
    Route::delete('/service/delete/{id}',       ['uses'=>'ServiceController@destroy',           'as'=>'auth.service.delete'])->middleware('permission:delete-service');
    Route::get('/service/getdata',              ['uses'=>'ServiceController@getdata',           'as'=>'auth.service.getdata'])->middleware('permission:view-service');
    Route::post('/service/change-status',       ['uses'=>'ServiceController@changeStatus',      'as'=>'auth.service.change-status'])->middleware('permission:changestatus-service');

    //Product Category
    Route::get('/product_category',                     ['uses'=>'ProductCategoryController@index',         'as'=>'auth.product_category.index'])->middleware('permission:view-product-category');
    Route::get('/product_category/create',              ['uses'=>'ProductCategoryController@create',        'as'=>'auth.product_category.create'])->middleware('permission:add-product-category');
    Route::post('/product_category/store',              ['uses'=>'ProductCategoryController@store',         'as'=>'auth.product_category.store'])->middleware('permission:add-product-category');
    Route::get('/product_category/edit/{id}',           ['uses'=>'ProductCategoryController@edit',          'as'=>'auth.product_category.edit'])->middleware('permission:edit-product-category');
    Route::post('/product_category/update/{id}',        ['uses'=>'ProductCategoryController@update',        'as'=>'auth.product_category.update'])->middleware('permission:edit-product-category');
    Route::delete('/product_category/delete/{id}',      ['uses'=>'ProductCategoryController@destroy',       'as'=>'auth.product_category.delete'])->middleware('permission:delete-product-category');
    Route::get('/product_category/getdata',             ['uses'=>'ProductCategoryController@getdata',       'as'=>'auth.product_category.getdata'])->middleware('permission:view-product-category');
    Route::post('/product_category/change-status',      ['uses'=>'ProductCategoryController@changeStatus',  'as'=>'auth.product_category.change-status'])->middleware('permission:changestatus-product-category');
    Route::get('/product_category/owner',               ['uses'=>'ProductCategoryController@owner',         'as'=>'auth.product_category.owner'])->middleware('permission:owner-product-category');
    Route::get('/product_category/createdBy/{id}',      ['uses'=>'ProductCategoryController@createdBy',     'as'=>'auth.product_category.createdBy'])->middleware('permission:owner-product-category');


    //Product
    Route::get('/product',                  ['uses'=>'ProductController@index',         'as'=>'auth.product.index'])->middleware('permission:view-product');
    Route::get('/product/create',           ['uses'=>'ProductController@create',        'as'=>'auth.product.create'])->middleware('permission:add-product');
    Route::post('/product/store',           ['uses'=>'ProductController@store',         'as'=>'auth.product.store'])->middleware('permission:add-product');
    Route::get('/product/edit/{id}',        ['uses'=>'ProductController@edit',          'as'=>'auth.product.edit'])->middleware('permission:edit-product');
    Route::post('/product/update/{id}',     ['uses'=>'ProductController@update',        'as'=>'auth.product.update'])->middleware('permission:edit-product');
    Route::delete('/product/delete/{id}',   ['uses'=>'ProductController@destroy',       'as'=>'auth.product.delete'])->middleware('permission:delete-product');
    Route::get('/product/getdata',          ['uses'=>'ProductController@getdata',       'as'=>'auth.product.getdata'])->middleware('permission:view-product');
    Route::post('/product/change-status',   ['uses'=>'ProductController@changeStatus',  'as'=>'auth.product.change-status'])->middleware('permission:changestatus-product');
    Route::get('/product/owner',            ['uses'=>'ProductController@owner',         'as'=>'auth.product.owner'])->middleware('permission:owner-product-category');
    Route::get('/product/createdBy/{id}',   ['uses'=>'ProductController@createdBy',     'as'=>'auth.product.createdBy'])->middleware('permission:owner-product');
    Route::post('/product/paid',            ['uses'=>'ProductController@paid',          'as'=>'auth.product.paid'])->middleware('permission:changestatus-product');


    //ProductOwner
    Route::get('/product_owner',                    ['uses'=>'ProductOwnerController@index',    'as'=>'auth.product_owner.index'])->middleware('permission:owner-product');
    Route::get('/product_owner/edit/{id}',          ['uses'=>'ProductOwnerController@edit',     'as'=>'auth.product_owner.edit'])->middleware('permission:owner-product');
    Route::post('/product_owner/update/{id}',       ['uses'=>'ProductOwnerController@update',   'as'=>'auth.product_owner.update'])->middleware('permission:owner-product');
    Route::delete('/product_owner/delete/{id}',     ['uses'=>'ProductOwnerController@destroy',  'as'=>'auth.product_owner.delete'])->middleware('permission:owner-product');
    Route::get('/product_owner/getdata',            ['uses'=>'ProductOwnerController@getdata',  'as'=>'auth.product_owner.getdata'])->middleware('permission:owner-product');


    //Product Image
    Route::get('/product_image/{id}',               ['uses'=>'ProductImageController@index',    'as'=>'auth.product_image.index'])->middleware('permission:view-product-image');
    Route::get('/product_image/create/{id}',        ['uses'=>'ProductImageController@create',   'as'=>'auth.product_image.create'])->middleware('permission:add-product-image');
    Route::post('/product_image/store/{id}',        ['uses'=>'ProductImageController@store',    'as'=>'auth.product_image.store'])->middleware('permission:add-product-image');
    Route::delete('/product_image/delete/{id}',     ['uses'=>'ProductImageController@destroy',  'as'=>'auth.product_image.delete'])->middleware('permission:delete-product-image');

    // Property Category
    Route::get('/property_category',                ['uses'=>'PropertyCategoryController@index',    'as'=>'auth.property_category.index'])->middleware('permission:view-property-category');
    Route::get('/property_category/create',         ['uses'=>'PropertyCategoryController@create',   'as'=>'auth.property_category.create'])->middleware('permission:add-property-category');
    Route::post('/property_category/store',         ['uses'=>'PropertyCategoryController@store',    'as'=>'auth.property_category.store'])->middleware('permission:add-property-category');
    Route::get('/property_category/edit/{id}',      ['uses'=>'PropertyCategoryController@edit',     'as'=>'auth.property_category.edit'])->middleware('permission:edit-property-category');
    Route::post('/property_category/update/{id}',   ['uses'=>'PropertyCategoryController@update',   'as'=>'auth.property_category.update'])->middleware('permission:edit-property-category');
    Route::delete('/property_category/delete/{id}', ['uses'=>'PropertyCategoryController@destroy',  'as'=>'auth.property_category.delete'])->middleware('permission:delete-property-category');
    Route::get('/property_category/getdata',        ['uses'=>'PropertyCategoryController@getdata',  'as'=>'auth.property_category.getdata'])->middleware('permission:view-property-category');
    Route::post('/property_category/change-status', ['uses'=>'PropertyCategoryController@changeStatus', 'as'=>'auth.property_category.change-status'])->middleware('permission:changestatus-property-category');


    // Property Sub-Category
    Route::get('/property_subcategory',                 ['uses'=>'PropertySubCategoryController@index',         'as'=>'auth.property_subcategory.index'])->middleware('permission:view-property-subcategory');
    Route::get('/property_subcategory/create',          ['uses'=>'PropertySubCategoryController@create',        'as'=>'auth.property_subcategory.create'])->middleware('permission:add-property-subcategory');
    Route::post('/property_subcategory/store',          ['uses'=>'PropertySubCategoryController@store',         'as'=>'auth.property_subcategory.store'])->middleware('permission:add-property-subcategory');
    Route::get('/property_subcategory/edit/{id}',       ['uses'=>'PropertySubCategoryController@edit',          'as'=>'auth.property_subcategory.edit'])->middleware('permission:edit-property-subcategory');
    Route::post('/property_subcategory/update/{id}',    ['uses'=>'PropertySubCategoryController@update',        'as'=>'auth.property_subcategory.update'])->middleware('permission:edit-property-subcategory');
    Route::delete('/property_subcategory/delete/{id}',  ['uses'=>'PropertySubCategoryController@destroy',       'as'=>'auth.property_subcategory.delete'])->middleware('permission:delete-property-subcategory');
    Route::get('/property_subcategory/getdata',         ['uses'=>'PropertySubCategoryController@getdata',       'as'=>'auth.property_subcategory.getdata'])->middleware('permission:view-property-subcategory');
    Route::post('/property_subcategory/change-status',  ['uses'=>'PropertySubCategoryController@changeStatus',  'as'=>'auth.property_subcategory.change-status'])->middleware('permission:changestatus-property-subcategory');


    // ForntEnd Property
    Route::get('/property',                     ['uses'=>'PropertyController@index',                'as'=>'auth.property.index'])->middleware('permission:view-property');
    Route::get('/property/create',              ['uses'=>'PropertyController@create',               'as'=>'auth.property.create'])->middleware('permission:add-property');
    Route::post('/property/store',              ['uses'=>'PropertyController@store',                'as'=>'auth.property.store'])->middleware('permission:add-property');
    Route::get('/property/edit/{id}',           ['uses'=>'PropertyController@edit',                 'as'=>'auth.property.edit'])->middleware('permission:edit-property');
    Route::post('/property/update/{id}',        ['uses'=>'PropertyController@update',               'as'=>'auth.property.update'])->middleware('permission:edit-property');
    Route::delete('/property/delete/{id}',      ['uses'=>'PropertyController@destroy',              'as'=>'auth.property.delete'])->middleware('permission:delete-property');
    Route::get('/property/getdata',             ['uses'=>'PropertyController@getdata',              'as'=>'auth.property.getdata'])->middleware('permission:view-property');
    Route::post('/property/change-status',      ['uses'=>'PropertyController@changeStatus',         'as'=>'auth.property.change-status'])->middleware('permission:changestatus-property');
    Route::get('/property/getsubcategory',      ['uses'=>'PropertyController@getsubcategory',       'as'=>'auth.property.getsubcategory'])->middleware('permission:add-property');
    Route::post('/property/sold',               ['uses'=>'PropertyController@sold',                 'as'=>'auth.property.sold'])->middleware('permission:changestatus-property');
    Route::post('/property/paid',               ['uses'=>'PropertyController@paid',                 'as'=>'auth.property.paid'])->middleware('permission:changestatus-property');
    Route::get('/property/getusertype',         ['uses'=>'PropertyController@getusertype',          'as'=>'auth.property.getusertype'])->middleware('permission:changestatus-property');
    Route::get('/property/getuser',             ['uses'=>'PropertyController@getuser',              'as'=>'auth.property.getuser'])->middleware('permission:changestatus-property');
    Route::post('property/assignUsertype',      ['uses'=>'PropertyController@assignUsertype',       'as'=>'auth.property.assignUsertype'])->middleware('permission:changestatus-property');
    Route::get('/property/getplace',            ['uses'=>'PropertyController@getplace',             'as'=>'auth.property.getplace'])->middleware('permission:add-property');


    //ForntEnd Property Image
    Route::get('/property_image/{id}',              ['uses'=>'PropertyImageController@index',       'as'=>'auth.property_image.index'])->middleware('permission:view-property-image');
    Route::get('/property_image/create/{id}',       ['uses'=>'PropertyImageController@create',      'as'=>'auth.property_image.create'])->middleware('permission:add-property-image');
    Route::post('/property_image/store/{id}',       ['uses'=>'PropertyImageController@store',       'as'=>'auth.property_image.store'])->middleware('permission:add-property-image');
    Route::delete('/property_image/delete/{id}',    ['uses'=>'PropertyImageController@destroy',     'as'=>'auth.property_image.delete'])->middleware('permission:delete-property-image');

    //FrontEnd Place
    Route::get('/place',                     ['uses'=>'PlaceController@index',          'as'=>'auth.place.index'])->middleware('permission:view-place');
    Route::get('/place/create',              ['uses'=>'PlaceController@create',         'as'=>'auth.place.create'])->middleware('permission:add-place');
    Route::post('/place/store',              ['uses'=>'PlaceController@store',          'as'=>'auth.place.store'])->middleware('permission:add-place');
    Route::get('/place/edit/{id}',           ['uses'=>'PlaceController@edit',           'as'=>'auth.place.edit'])->middleware('permission:edit-place');
    Route::post('/place/update/{id}',        ['uses'=>'PlaceController@update',         'as'=>'auth.place.update'])->middleware('permission:edit-place');
    Route::delete('/place/delete/{id}',      ['uses'=>'PlaceController@destroy',        'as'=>'auth.place.delete'])->middleware('permission:delete-place');
    Route::get('/place/getdata',             ['uses'=>'PlaceController@getdata',        'as'=>'auth.place.getdata'])->middleware('permission:add-place');

});

//FrontEnd View
Route::get('/view/profile/',            ['uses'=>'HomeController@viewprofile',      'as'=>'view.profile'])->middleware('URL');
Route::post('/assign/',                 ['uses'=>'HomeController@assign',           'as'=>'home.assign']);
Route::get('home_autocomplete/{id}',    ['uses'=>'HomeController@autocomplete',     'as'=>'home_autocomplete']);
// Route::get('/contact',                  ['uses'=>'HomeController@contact',          'as'=>'home.contact']);
Route::post('quicksearch/',             ['uses'=>'HomeController@search',           'as'=>'home.search']);

//FrontEnd Property
Route::get('/property/create',          ['uses'=>'PropertyController@create',               'as'=>'property.create'])->middleware('URL');
Route::get('property/{slug}',           ['uses'=>'PropertyController@index',                'as'=>'property.index']);
Route::get('property/show/{slug}',      ['uses'=>'PropertyController@show',                 'as'=>'property.show']);
Route::post('/property/search',         ['uses'=>'PropertyController@search',               'as'=>'property.search']);
Route::post('/property/home/search',    ['uses'=>'PropertyController@homepagesearch',       'as'=>'property.home.search']);
// Route::get('getpropertypage',           ['uses'=>'PropertyController@getpagebynumber',      'as'=>'getpropertypage']);
Route::get('getplace',                  ['uses'=>'PropertyController@getplace',             'as'=>'getplace']);
Route::get('property_autocomplete',     ['uses'=>'PropertyController@autocomplete',         'as'=>'property_autocomplete']);
Route::post('property/getsearch',       ['uses'=>'PropertyController@getsearch',            'as'=>'property.getsearch']);
Route::post('/property/update/{id}',    ['uses'=>'PropertyController@update',               'as'=>'property.update']);
Route::delete('/property/delete/{id}',  ['uses'=>'PropertyController@destroy',              'as'=>'property.delete']);





Route::get('property/edit/{slug}',             ['uses'=>'PropertyController@edit',                      'as'=>'property.edit']);
Route::post('property/store',                  ['uses'=>'PropertyController@store',                     'as'=>'property.store']);
Route::get('/getplace',                        ['uses'=>'PropertyController@getplace',                  'as'=>'place.getplace']);
Route::get('/property_sub/getsubcategory',     ['uses'=>'PropertySubcategoryController@getsubcategory', 'as'=>'property_sub.getsubcategory']);




// property owner Controller
Route::get('/property_owner/',              ['uses'=>'PropertyOwnerController@index',                   'as'=>'owner.property.index'])->middleware('URL');
Route::get('/get_owner_property/',          ['uses'=>'PropertyOwnerController@get_owner_property',      'as'=>'owner.property.getdata'])->middleware('URL');
Route::get('/property_owner/edit/{slug}',   ['uses'=>'PropertyOwnerController@edit',                    'as'=>'owner.property.edit'])->middleware('URL');


// property as broker
Route::get('/property_broker',              ['uses'=>'BrokerController@index',                          'as'=>'broker.property.index']);
Route::get('/get_broker_property/',         ['uses'=>'BrokerController@get_broker_property',            'as'=>'broker.property.getdata']);


// property image gllery
Route::get('property_image/show/{slug}',    ['uses'=>'PropertyImageController@show',                    'as'=>'property_image.show']);
Route::post('property_image/store/',        ['uses'=>'PropertyImageController@store',                   'as'=>'property_image.store']);
Route::post('/property_image/delete/',      ['uses'=>'PropertyImageController@destroy',                 'as'=>'property_image.delete']);

//FrontEnd Service
Route::get('/service',                      ['uses'=>'ServiceController@index',                         'as'=>'service.index']);
Route::get('/service/create',               ['uses'=>'ServiceController@create',                        'as'=>'service.create'])->middleware('admin');
Route::get('/service/{show}',               ['uses'=>'ServiceController@show',                          'as'=>'service.show']);
Route::post('/service/search',              ['uses'=>'ServiceController@search',                        'as'=>'service.search']);
Route::post('/service/home/search',         ['uses'=>'ServiceController@homesearch',                    'as'=>'service.home.search']);
Route::post('/service/store',               ['uses'=>'ServiceController@store',                         'as'=>'service.store']);
Route::get('/service-category/{slug}',      ['uses'=>'ServiceController@servicecategory',               'as'=>'category.show']);

//Service Category
Route::get('service/subcategory/getsubcategory',    ['uses'=>'ServiceSubcategoryController@getsubcategory',     'as'=>'service.subcategory.getsubcategory']);
Route::get('service/subcategory/show/{slug}',       ['uses'=>'ServiceSubcategoryController@show',               'as'=>'subcategory.show']);
Route::post('category/getcategory',                 ['uses'=>'ServiceSubcategoryController@getcategory',        'as'=>'category.getcategory']);
Route::post('category/getsubcategory',              ['uses'=>'ServiceSubcategoryController@getsubcategory',     'as'=>'category.getsubcategory']);
Route::post('category/getTitle',                    ['uses'=>'ServiceSubcategoryController@getTitle',           'as'=>'category.getTitle']);


/// product route
//Route::get('/{slug}','ProductController@index')->name('product.index');
Route::get('/product/create',                   ['uses'=>'ProductController@create',        'as'=>'product.create']);
Route::get('product/show/{slug}',               ['uses'=>'ProductController@show',          'as'=>'product.show']);
Route::get('/getcategory/',                     ['uses'=>'ProductController@getcategory',   'as'=>'getcategory']);
Route::post('/product/store',                   ['uses'=>'ProductController@store',         'as'=>'product.store']);
Route::post('/product/search',                  ['uses'=>'ProductController@search',        'as'=>'product.search']);
Route::post('/product/home/search',             ['uses'=>'ProductController@homesearch',    'as'=>'product.home.search']);
Route::get('product_autocomplete/{slug}',       ['uses'=>'ProductController@autocomplete',  'as'=>'product_autocomplete']);
Route::get('product/edit/{slug}',               ['uses'=>'ProductController@edit',          'as'=>'product.edit']);
Route::post('/product/update/{id}',             ['uses'=>'ProductController@update',        'as'=>'product.update']);

Route::get('/product/category',                 ['uses'=>'ProductCategoryController@index',             'as'=>'product.category']);
Route::get('/product/title',                    ['uses'=>'ProductCategoryController@autocompleteTitle', 'as'=>'product.title']);

//product image
Route::get('product_image/show/{slug}',         ['uses'=>'ProductImageController@show',     'as'=>'product_image.show']);
Route::post('product_image/store/',             ['uses'=>'ProductImageController@store',    'as'=>'product_image.store']);
Route::post('product_image/delete/',            ['uses'=>'ProductImageController@destroy',  'as'=>'product_image.delete']);

Route::get('product/category/{slug}',           ['uses'=>'ProductCategoryController@show',  'as'=>'product.category.show']);
Route::delete('/product/delete/{id}',           ['uses'=>'ProductController@destroy',       'as'=>'product.delete']);



//owner prodcut
Route::get('/owner/product/',                   ['uses'=>'OwnerProductController@index',        'as'=>'owner.product.index'])->middleware('URL');
Route::get('/owner_product_getdata/',           ['uses'=>'OwnerProductController@getdata',      'as'=>'owner.product.getdata'])->middleware('URL');
Route::get('/property_owner/edit/{slug}',       ['uses'=>'OwnerProductController@edit',         'as'=>'owner.product.edit'])->middleware('URL');
Route::post('/owner_product/change-status',     ['uses'=>'OwnerProductController@changeStatus', 'as'=>'owner.product.change-status'])->middleware('URL');
Route::post('/owner_product/paid',              ['uses'=>'OwnerProductController@paid',         'as'=>'owner.product.paid'])->middleware('URL');



//Getting Sub Category
Route::get('/getsubcategory/',                  ['uses'=>'HomeController@getsubcategory',       'as'=>'getsubcategory']);


//Contact
Route::get('/contact',                          ['uses'=>'ContactController@index',   'as'=>'contact.index']);
Route::post('/contact/store',                   ['uses'=>'ContactController@store',   'as'=>'contact.store']);

//Cart
//Route::get('add/cart','CartController@store')->name('cart.add');
Route::get('cart/',                             ['uses'=>'CartController@index',    'as'=>'cart.index']);
Route::post('cart/add/',                        ['uses'=>'CartController@store',    'as'=>'cart.add']);
Route::post('cart/location/',                   ['uses'=>'CartController@location', 'as'=>'cart.location']);
Route::get('cart/checkout/',                    ['uses'=>'CartController@checkout', 'as'=>'cart.checkout'])->middleware('URL');
Route::delete('/delete/',                       ['uses'=>'CartController@flush',    'as'=>'cart.delete']);
Route::get('cart/remove/{id}',                  ['uses'=>'CartController@remove',   'as'=>'cart.remove']);

//Skills
Route::get('skill/create',                      ['uses'=>'SkillController@create',  'as'=>'skill.create'])->middleware('auth');
Route::post('skill/store',                      ['uses'=>'SkillController@store',   'as'=>'skill.store'])->middleware('auth');


//Certificate
Route::post('certificate/store',                ['uses'=>'CertificateController@store',     'as'=>'certificate.store'])->middleware('auth');
Route::post('certificate/delete/',              ['uses'=>'ProductImageController@destroy',  'as'=>'certificate.delete'])->middleware('URL');

//Service Request
Route::get('/servicerequest',                   ['uses'=>'ServiceRequestController@index',              'as'=>'servicerequest.index'])->middleware('URL');
Route::get('/servicerequest/show/{id}',         ['uses'=>'ServiceRequestController@show',               'as'=>'servicerequest.show'])->middleware('URL');
Route::get('/servicerequest/technician/',       ['uses'=>'ServiceRequestController@assignService',      'as'=>'servicerequest.technician'])->middleware('URL');
Route::post('service_request/store/{id}',       ['uses'=>'ServiceRequestController@store',              'as'=>'service_request.store'])->middleware('URL');
Route::get('service_request/store/{id}',        ['uses'=>'ServiceRequestController@store',              'as'=>'service_request.store'])->middleware('URL');
Route::get('servicerequest/delete/{id}',        ['uses'=>'ServiceRequestController@destroy',            'as'=>'servicerequest.delete'])->middleware('URL');
Route::post('/servicerequest/details',          ['uses'=>'ServiceRequestController@details',            'as'=>'servicerequest.details']);

//Request
Route::post('request/timer',                    ['uses'=>'ServiceRequestController@requestTime',        'as'=>'request.timer'])->middleware('URL');
Route::post('request/finished',                 ['uses'=>'ServiceRequestController@requesFinished',     'as'=>'request.finished'])->middleware('URL');
Route::post('request/count',                    ['uses'=>'ServiceRequestController@count',              'as'=>'request.count'])->middleware('URL');


//Order
Route::get('order/service/show/{id}',           ['uses'=>'ServiceOrderController@show',                 'as'=>'order.service.show'])->middleware('URL');
Route::get('assign/service/show/{id}',          ['uses'=>'ServiceOrderController@assign',               'as'=>'assign.service.show'])->middleware('URL');

//Ticket
Route::post('ticket/store/{id}',                ['uses'=>'TicketController@store',                      'as'=>'ticket.store'])->middleware('URL');
Route::delete('ticket/delete/{id}',             ['uses'=>'TicketController@destroy',                    'as'=>'ticket.delete'])->middleware('URL');
Route::post('/ticket/change-status',            ['uses'=>'TicketController@changeStatus',               'as'=>'ticket.change-status'])->middleware('URL');


//Device Storing
Route::post('device/store/',                    ['uses'=>'DeviceController@store',                      'as'=>'device.store'])->middleware('auth');


// this route is for the notification only

Route::get('notification',                      ['uses'=>'NotificationController@index',            'as'=>'notification.index'])->middleware('URL');

Route::post('place/getlocation',                ['uses'=>'PlaceController@getlocation',             'as'=>'place.getlocation']);
Route::post('place/getaddress',                 ['uses'=>'PlaceController@place',                   'as'=>'place.getaddress']);

Route::post('booking/store',                    ['uses'=>'BookingController@store',                 'as'=>'booking.store'])->middleware('URL');
Route::get('booking/order/{id}',                ['uses'=>'BookingController@order',                 'as'=>'booking.order'])->middleware('URL');
Route::get('booking/update/{id}',               ['uses'=>'BookingController@update',                'as'=>'booking.update'])->middleware('URL');

Route::post('/booking/property/change-status',  ['uses'=>'BookingController@changeStatus',          'as'=>'booking.property.change-status'])->middleware('URL');
Route::get('ordered/property',                  ['uses'=>'BookingController@orderdProperty',        'as'=>'ordered.property'])->middleware('URL');



// this route is for the transaction of the user

Route::get('transaction',                       ['uses'=>'TransactionController@index',             'as'=>'transaction.index'])->middleware('URL');


Route::get('product/search/{page_number?}',     ['uses'=>'ProductController@perpage',               'as'=>'perpage']);
Route::get('order/show/{id}',                   ['uses'=>'ProductOrderController@show',             'as'=>'order.show']);
Route::post('/order/change-status',             ['uses'=>'ProductOrderController@changeStatus',     'as'=>'order.change-status'])->middleware('URL');




//this route for the broker form submit and edit profile
Route::post('broker/store',                     ['uses'=>'BrokerController@store',      'as'=>'broker.store'])->middleware('URL');
Route::post('broker/update',                    ['uses'=>'BrokerController@update',     'as'=>'broker.update'])->middleware('URL');


//this router for the vendor form submit
Route::post('vendor/store',                     ['uses'=>'VendorController@store',      'as'=>'vendor.store'])->middleware('URL');
Route::post('vendor/update',                    ['uses'=>'VendorController@update',     'as'=>'vendor.update'])->middleware('URL');

//this router for the technician form submit
Route::post('technician/store',                 ['uses'=>'TechnicianController@store',   'as'=>'technician.store'])->middleware('URL');
Route::post('technician/update',                ['uses'=>'TechnicianController@update',  'as'=>'technician.update'])->middleware('URL');


// this is profile edit
Route::post('profile/update',                   ['uses'=>'ProfileController@profile',    'as'=>'profile.update'])->middleware('URL');


// this is prodcut sells report
Route::get('order/product',                     ['uses'=>'ProductOrderController@index', 'as'=>'order.product'])->middleware('URL');
Route::get('sold/product',                      ['uses'=>'ProductOrderController@sold',  'as'=>'sold.product'])->middleware('URL');

View::composer(['*'], function($view){
        $setting = Setting::where('is_active',1)->first();
        $view->with(compact('setting'));
});