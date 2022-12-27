<?php

namespace Newnet\Core\SettingBuilders;

use Newnet\Core\Services\AdminSetting\BaseSettingBuilder;
use Newnet\Media\Models\Media;

class GeneralSettingBuilder extends BaseSettingBuilder
{
    public function getTitle()
    {
        return __('core::setting-builder.general.panel_title');
    }

    public function save()
    {
        setting($this->request->only([
            'theme_name',
            'disable_megamenu',
            'site_title',
            'admin_email',
            'timezone',
            'redirect_404_to_home',
        ]));

        setting(['logo' => Media::find($this->request->input('logo'))]);
        setting(['logo_login' => Media::find($this->request->input('logo_login'))]);
        setting(['logo_admin' => Media::find($this->request->input('logo_admin'))]);
        setting(['favicon' => Media::find($this->request->input('favicon'))]);

    }

    public function render()
    {
        $item = new \stdClass();
        $item->site_title = setting('site_title');
        $item->admin_email = setting('admin_email');
        $item->timezone = setting('timezone');
        $item->logo = setting('logo');
        $item->logo_login = setting('logo_login');
        $item->logo_admin = setting('logo_admin');
        $item->favicon = setting('favicon');
        $item->redirect_404_to_home = setting('redirect_404_to_home');
        $item->theme_name = setting('theme_name');
        $item->disable_megamenu = setting('disable_megamenu');

        return view('core::setting-builder.general', compact('item'));
    }
}
