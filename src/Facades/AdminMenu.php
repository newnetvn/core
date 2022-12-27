<?php

namespace Newnet\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Newnet\Core\Services\Menu\AdminMenuBuilder;

class AdminMenu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AdminMenuBuilder::class;
    }
}
