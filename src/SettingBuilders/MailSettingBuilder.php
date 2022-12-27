<?php

namespace Newnet\Core\SettingBuilders;

use Newnet\Core\Services\AdminSetting\BaseSettingBuilder;

class MailSettingBuilder extends BaseSettingBuilder
{
    public function getTitle()
    {
        return __('core::setting-mail.panel_title');
    }

    public function save()
    {
        setting($this->request->only([
            'mail_driver',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            
            'mail_address',
            'mail_name',
            
            'mail_secret',
            'mail_key',
            'mail_region',
        ]));
    }

    public function render()
    {
        $item = new \stdClass();
        $item->mail_driver = setting('mail_driver');
        $item->mail_host = setting('mail_host');
        $item->mail_port = setting('mail_port');
        $item->mail_username = setting('mail_username');
        $item->mail_password = setting('mail_password');
        $item->mail_encryption = setting('mail_encryption');
        
        $item->mail_address = setting('mail_address');
        $item->mail_name = setting('mail_name');
        
        $item->mail_secret = setting('mail_secret');
        $item->mail_key = setting('mail_key');
        $item->mail_region = setting('mail_region');
        
        return view('core::setting-builder.mail-setting', compact('item'));
    }
}
