<?php

namespace Newnet\Core\Services\AdminSetting;

interface SettingBuilderInterface
{
    /**
     * Get setting panel title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Render panel view row
     *
     * @return mixed
     */
    public function render();

    /**
     * Save setting to database
     *
     * @return mixed
     */
    public function save();
}
