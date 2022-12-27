<?php

namespace Newnet\Core\Services\AdminSetting;

use Illuminate\Http\Request;

abstract class BaseSettingBuilder implements SettingBuilderInterface
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
