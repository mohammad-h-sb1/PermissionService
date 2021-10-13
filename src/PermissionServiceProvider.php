<?php

namespace Saberyp\Cms;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Cms',function (){
            return new Permission;
        });
    }

    public function boot()
    {
        require __DIR__ . '\routes\api.php';
        $this->publishes([
            __DIR__.'/database'=>database_path('/migrations'),
            __DIR__ . '/config/mine.php' =>config_path('cms.php'),

            __DIR__.'/App/Http/Admin/ProfileController.php'=>base_path('App/Http/Controllers/Admin/ProfileController.php'),
            __DIR__.'/App/Http/ProfileController.php'=>base_path('App/Http/Controllers/ProfileController.php'),
            __DIR__.'/App/Http/UserController.php'=>base_path('App/Http/Controllers/UserController.php'),
            __DIR__.'/App/Http/PermissionController.php'=>base_path('App/Http/Controllers/PermissionController.php'),
            __DIR__.'/App/Http/RoleController.php'=>base_path('App/Http/Controllers/RoleController.php'),

            __DIR__.'/App/Resource/Admin/ProfileResource.php'=>base_path('App/Http/Resources/Admin/ProfileResource.php'),
            __DIR__.'/App/Resource/ProfileResource.php'=>base_path('App/Http/Resources/ProfileResource.php'),
            __DIR__.'/App/Resource/PermissionResource.php'=>base_path('App/Http/Resources/PermissionResource.php'),
            __DIR__.'/App/Resource/RoleResource.php'=>base_path('App/Http/Resources/RoleResource.php'),

            __DIR__.'/App/Models/Permission.php'=>base_path('App/Models/Permission.php'),
            __DIR__.'/App/Models/Profile.php'=>base_path('App/Models/Profile.php'),
            __DIR__.'/App/Models/Role.php'=>base_path('App/Models/Role.php'),

        ]);
        foreach (\Saberyp\Cms\App\Models\Permission::all() as $permission){
            Gate::define($permission->name,function ($user) use ($permission){
                return $user->hasPermission($permission);
            });
        }


    }
}
