<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        if (Schema::hasTable('permission')) {
            $permissions = Permission::all();
            foreach($permissions as $value){
                $slug =$value->slug;
                Gate::define($slug, function() use($slug){
                    return in_array($slug, session()->get('access_permissions'));
                });
            }
        } 
        


    }
}
