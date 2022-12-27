<?php

namespace Newnet\Core\Support\Theme;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * @deprecated
 */
abstract class BaseThemeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerHelper();
    }

    public function boot()
    {
        $this->loadRoutes();
        $this->loadTranslationsFrom($this->getThemeDir().'/resources/lang', 'theme');
    }

    protected function loadRoutes()
    {
        $routeAdmin = $this->getThemeDir().'/routes/admin.php';
        if (file_exists($routeAdmin)) {
            Route::middleware(config('core.admin_middleware'))
                ->domain(config('core.admin_domain'))
                ->prefix(config('core.admin_prefix'))
                ->group($routeAdmin);
        }

        $routeWeb = $this->getThemeDir().'/routes/web.php';
        if (file_exists($routeWeb)) {
            Route::middleware(['web'])
                ->group($routeWeb);
        }

        $routeApi = $this->getThemeDir().'/routes/api.php';
        if (file_exists($routeApi)) {
            Route::middleware(['api'])
                ->prefix('api')
                ->group($routeApi);
        }
    }

    protected function registerHelper()
    {
        $helperFile = $this->getThemeDir().'/src/helpers.php';
        if (file_exists($helperFile)) {
            require_once $helperFile;
        }
    }

    protected function getThemeDir()
    {
        $class_info = new \ReflectionClass($this);
        return dirname(dirname($class_info->getFileName()));
    }
}
