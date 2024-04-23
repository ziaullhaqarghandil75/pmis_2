<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use App\Models\account_settings\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        foreach($this->getPermissions() as $permission){
            // dd($permission->roles());
            Gate::define($permission->name, function($user) use ($permission){
            //    dd($permission->roles());
                return $user->hasRole($permission->roles);
            });
           
        }
    
    }
    public function getPermissions(){
        return Permission::with("roles")->get();
   }
}
