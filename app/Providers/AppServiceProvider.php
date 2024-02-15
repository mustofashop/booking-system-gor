<?php

namespace App\Providers;

use App\Models\Sidebar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer(['*'], function ($view) {
            $masterSidebars = $this->getMenuData();
//            dd($masterSidebars);
//            header('Content-type: application/json');
//            echo json_encode($menuData, JSON_PRETTY_PRINT);
//            die();
            $view->with('masterSidebars', $masterSidebars);
        });
    }

    public function getMenuData()
    {
        // Check if a user is authenticated
        if (Auth::check()) {
            // Ambil izin-izin yang dimiliki oleh peran-peran pengguna
            $permissions = Auth::user()->permissions()->pluck('permission_id');

            // Ambil menu-menu yang memiliki izin-izin yang sesuai dengan izin-izin pengguna
            $menus = Sidebar::with(['sidebarMain' => function ($query) use ($permissions) {
                $query->whereHas('permission', function ($query) use ($permissions) {
                    // Filter items based on permissions
                    $query->whereIn('permission_id', $permissions);
                })->orderBy('ordering', 'ASC');
            }])
                ->where('status', 'ACTIVE')
                ->orderBy('ordering', 'ASC')
                ->get();

//            header('Content-type: application/json');
//            echo json_encode($menus, JSON_PRETTY_PRINT);
//            die();

            return $menus;
        } else {
            return [];
        }
    }


}
