<?php

namespace Newnet\Core\Services\AdminSetting;

class SettingBuilderGroup
{
    /** @var SettingBuilderInterface[] */
    protected $panels = [];

    /** @var array Setting Class Name */
    protected $settings = [];

    protected $builded = false;

    /**
     * Add setting class name
     *
     * @param $className
     * @return SettingBuilderGroup
     */
    public function add($className)
    {
        $this->settings[] = $className;

        return $this;
    }

    /**
     * Build all setting class
     */
    protected function build()
    {
        if ($this->builded) {
            return;
        }

        foreach (array_unique($this->settings) as $setting) {
            $settingBuilder = app($setting);
            $this->panels[] = $settingBuilder;
        }

        $this->builded = true;
    }

    public function getPanels()
    {
        $this->build();

        return $this->panels;
    }

    public function save()
    {
        $this->build();

        foreach ($this->panels as $panel) {
            $panel->save();
        }
    }
}
