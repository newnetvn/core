<?php

namespace Newnet\Core\SettingBuilders;

use Newnet\Core\Services\AdminSetting\BaseSettingBuilder;

class StyleScriptSettingBuilder extends BaseSettingBuilder
{
    public function getTitle()
    {
        return __('core::setting-code.panel_title');
    }

    public function save()
    {
        setting($this->request->only([
            'code_head',
            'code_footer',
        ]));
    }

    public function render()
    {
        $item = new \stdClass();
        $item->code_head = setting('code_head');
        $item->code_footer = setting('code_footer');

        return view('core::setting-builder.style-script-setting', compact('item'));
    }
}
