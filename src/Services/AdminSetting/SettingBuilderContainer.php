<?php

namespace Newnet\Core\Services\AdminSetting;

class SettingBuilderContainer
{
    protected $groups = [];

    /**
     * @param $groupKey
     * @return \Newnet\Core\Services\AdminSetting\SettingBuilderGroup
     */
    public function group($groupKey)
    {
        if (!isset($this->groups[$groupKey])) {
            $this->groups[$groupKey] = new SettingBuilderGroup();
        }

        return $this->groups[$groupKey];
    }

    /**
     * @return \Newnet\Core\Services\AdminSetting\SettingBuilderGroup
     */
    public function themeGroup()
    {
        return $this->group('theme');
    }

    public function __call($method, $arguments)
    {
        $defaultGroup = $this->defaultGroup();

        return call_user_func_array([$defaultGroup, $method], $arguments);
    }

    protected function defaultGroup()
    {
        return $this->group('default');
    }
}
