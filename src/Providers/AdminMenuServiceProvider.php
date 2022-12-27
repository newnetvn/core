<?php

namespace Newnet\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Newnet\Core\Services\Menu\AdminMenuBuilder;

class AdminMenuServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->app->singleton(AdminMenuBuilder::class, function () {
            return new AdminMenuBuilder();
        });
    }

    public function provides()
    {
        return [AdminMenuBuilder::class];
    }
}
