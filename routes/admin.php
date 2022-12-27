<?php

use Newnet\Core\Http\Controllers\Admin\SettingController;
use Newnet\Core\Http\Controllers\Admin\ThemeSettingController;

Route::prefix('setting')->group(function () {
    Route::get('', [SettingController::class, 'index'])
        ->name('core.admin.setting.index')
        ->middleware('admin.can:core.admin.setting.index');

    Route::post('', [SettingController::class, 'save'])
        ->name('core.admin.setting.save')
        ->middleware('admin.can:core.admin.setting.save');
});
