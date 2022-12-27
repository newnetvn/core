<?php

namespace Newnet\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Newnet\Core\Facades\SettingBuilder;
use Newnet\Core\Mail\CheckMailConfig;

class ThemeSettingController extends Controller
{
    public function index()
    {
        $panels = SettingBuilder::group('theme')->getPanels();

        return view('core::admin.theme-setting.index', compact('panels'));
    }

    public function save()
    {
        SettingBuilder::group('theme')->save();

        return redirect()
            ->route('core.admin.theme-setting.index')
            ->with('success', __('core::theme-setting.notification.updated'));
    }

    public function checkConfigMail(Request $request)
    {
        switch ($request->mail_driver) {
            case 'smtp':
                config([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.host' => $request->mail_host ?? setting('mail_host') ?? env('MAIL_HOST', 'smtp.mailgun.org'),
                    'mail.mailers.smtp.port' => $request->mail_port ?? setting('mail_port') ?? env('MAIL_PORT', 587),
                    'mail.mailers.smtp.encryption' => $request->mail_encryption ?? setting('mail_encryption') ?? env('MAIL_ENCRYPTION', 'tls'),
                    'mail.mailers.smtp.username' => $request->mail_username ?? setting('mail_username') ?? env('MAIL_USERNAME'),
                    'mail.mailers.smtp.password' => $request->mail_password ?? setting('mail_password') ?? env('MAIL_PASSWORD'),
                    'mail.from.address' => $request->mail_address ?? setting('mail_address') ?? env('MAIL_FROM_ADDRESS'),
                    'mail.from.name' => $request->mail_name ?? setting('mail_name') ?? env('MAIL_FROM_NAME'),
                ]);
                break;
            case 'ses':
                config([
                    'mail.default' => 'ses',
                    'mail.from.address' => $request->mail_address ?? setting('mail_address') ?? env('MAIL_FROM_ADDRESS'),
                    'mail.from.name' => $request->mail_name ?? setting('mail_name') ?? env('MAIL_FROM_NAME'),
                    'services.ses.key' => $request->mail_key ?? setting('mail_key'),
                    'services.ses.secret' => $request->mail_secret ?? setting('mail_secret'),
                    'services.ses.region' => $request->mail_region ?? setting('mail_region')
                ]);
                break;
        }

        Mail::to($request->mail_test)->send( new CheckMailConfig());
        return response()->json([
            'success' => true
        ]);
    }
}
