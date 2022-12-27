<?php

namespace Newnet\Core\Support\Module;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

abstract class BaseModuleServiceProvider extends ServiceProvider
{
    /**
     * Namespcae of view, translate, etc...
     *
     * @return mixed
     */
    abstract public function getModuleNamespace();

    public function boot()
    {
        $this->loadViewsFrom($this->getModuleDir().'/resources/views', $this->getModuleNamespace());
        $this->loadTranslationsFrom($this->getModuleDir().'/resources/lang', $this->getModuleNamespace());
        $this->loadMigrationsFrom($this->getModuleDir().'/database/migrations');

        if (is_dir($this->getModuleDir().'/public')) {
            $this->publishes([
                $this->getModuleDir().'/public' => public_path('vendor/'.$this->getModuleNamespace()),
            ], 'module-assets');
        }

        $this->loadRoutes();
        $this->registerPermissions();
        $this->registerAdminMenus();
        $this->registerFrontendMenuBuilders();
        $this->registerSettingBuilders();
        $this->registerDashboards();
    }

    protected function loadRoutes()
    {
        $routeAdmin = $this->getModuleDir().'/routes/admin.php';
        if (file_exists($routeAdmin)) {
            Route::middleware(config('core.admin_middleware'))
                ->domain(config('core.admin_domain'))
                ->prefix(config('core.admin_prefix'))
                ->group($routeAdmin);
        }

        $routeWeb = $this->getModuleDir().'/routes/web.php';
        if (file_exists($routeWeb)) {
            Route::middleware(['web'])
                ->group($routeWeb);
        }

        $routeApi = $this->getModuleDir().'/routes/api.php';
        if (file_exists($routeApi)) {
            Route::middleware(['api'])
                ->prefix('api')
                ->group($routeApi);
        }
    }

    protected function registerPermissions()
    {
        // Code
    }

    protected function registerAdminMenus()
    {
        // Code
    }

    protected function registerFrontendMenuBuilders()
    {

    }

    protected function registerSettingBuilders()
    {

    }

    protected function registerDashboards()
    {

    }

    protected function getModuleDir()
    {
        $class_info = new \ReflectionClass($this);
        return dirname(dirname($class_info->getFileName()));
    }
}
