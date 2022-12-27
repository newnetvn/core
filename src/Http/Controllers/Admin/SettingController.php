<?php

namespace Newnet\Core\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Newnet\Core\Facades\SettingBuilder;

class SettingController extends Controller
{
    public function index()
    {
        $panels = SettingBuilder::getPanels();

        return view('core::admin.setting.index', compact('panels'));
    }

    public function save()
    {
        SettingBuilder::save();

        if (request()->theme_name){
            return redirect()->back();
        }
        return redirect()
            ->route('core.admin.setting.index')
            ->with('success', __('core::setting.notification.updated'));
    }
}
