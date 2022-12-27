<?php

namespace Newnet\Core;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Newnet\Core\Console\Commands\CreateAdminAccountCommand;
use Newnet\Core\Console\Commands\InstallCommand;
use Newnet\Core\Console\Commands\LinkVendorCommand;
use Newnet\Core\Console\Commands\UpgradeCommand;
use Newnet\Core\Events\CoreAdminMenuRegistered;
use Newnet\Core\Facades\AdminMenu;
use Newnet\Core\Facades\SettingBuilder;
use Newnet\Core\Http\Middleware\TranslationAdminMiddleware;
use Newnet\Core\Providers\AdminMenuServiceProvider;
use Newnet\Core\Providers\ModuleServiceProvider;
use Newnet\Core\Services\AdminSetting\SettingBuilderContainer;
use Newnet\Core\SettingBuilders\GeneralSettingBuilder;
use Newnet\Core\SettingBuilders\MailSettingBuilder;
use Newnet\Core\SettingBuilders\StyleScriptSettingBuilder;

class CoreServiceProvider extends ServiceProvider
{
    protected $providers = [
        ModuleServiceProvider::class,
        AdminMenuServiceProvider::class,
    ];

    protected $commands = [
        UpgradeCommand::class,
    ];

    protected $commandsCli = [
        InstallCommand::class,
        CreateAdminAccountCommand::class,
        LinkVendorCommand::class,
    ];

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/core.php', 'core');
        $this->registerProviders();

        $coreConfigData = include __DIR__ . '/../config/core.php';
        $this->app['config']->set('app.debug_blacklist', $coreConfigData['debug_blacklist']);

        $this->app->singleton('newnet.setting-builder', SettingBuilderContainer::class);
        AliasLoader::getInstance()->alias('SettingBuilder', SettingBuilder::class);

        SettingBuilder::add(GeneralSettingBuilder::class);
//        SettingBuilder::add(StyleScriptSettingBuilder::class);
        SettingBuilder::add(MailSettingBuilder::class);
    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/core.php', 'core');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'core');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'core');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../public/newnet-admin' => public_path('vendor/newnet-admin'),
        ], 'newnet-admin');

        $this->publishes([
            __DIR__ . '/../config/core.php' => config_path('core.php'),
        ], 'core-config');

        $this->bootMailConfig();
        $this->registerCommands();
        $this->loadRoutes();
        $this->registerBlade();
        $this->registerAdminMenus();
        $this->registerMiddleware();
    }

    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    protected function registerCommands()
    {
        $this->commands($this->commands);

        if ($this->app->runningInConsole()) {
            $this->commands($this->commandsCli);
        }
    }

    protected function loadRoutes()
    {
        Route::middleware(config('core.admin_middleware'))
            ->domain(config('core.admin_domain'))
            ->prefix(config('core.admin_prefix'))
            ->group(__DIR__ . '/../routes/admin.php');
    }

    protected function registerBlade()
    {
        Blade::include('core::form.input', 'input');
        Blade::include('core::form.select', 'select');
        Blade::include('core::form.select2', 'select2');
        Blade::include('core::form.select2', 'selecth');
        Blade::include('core::form.textarea', 'textarea');
        Blade::include('core::form.editor', 'editor');
        Blade::include('core::form.file', 'file');
        Blade::include('core::form.image', 'image');
        Blade::include('core::form.checkbox', 'checkbox');
        Blade::include('core::form.sumoselect', 'sumoselect');
        Blade::include('core::form.slug', 'slug');
        Blade::include('core::form.media', 'mediafile');
        Blade::include('core::form.gallery', 'gallery');
        Blade::include('core::form.dateinput', 'dateinput');
        Blade::include('core::form.datetimeinput', 'datetimeinput');
        Blade::include('core::form.daterangeinput', 'daterangeinput');
        Blade::include('core::form.datetimerangeinput', 'datetimerangeinput');

        Blade::include('core::form.translatable', 'translatable');
        Blade::include('core::form.translatable-alert', 'translatableAlert');
        Blade::include('core::form.translatable-status', 'translatableStatus');
        Blade::include('core::form.translatable-header', 'translatableHeader');

        Blade::directive('vnmoney', function ($amount) {
            return "<?php echo vnmoney($amount); ?>";
        });
    }

    protected function registerMiddleware()
    {
        /** @var Router $router */
        $router = $this->app['router'];

        $router->pushMiddlewareToGroup('web', TranslationAdminMiddleware::class);

        $router->aliasMiddleware('localize', \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class);
        $router->aliasMiddleware('localizationRedirect', \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class);
        $router->aliasMiddleware('localeSessionRedirect', \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class);
        $router->aliasMiddleware('localeCookieRedirect', \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class);
        $router->aliasMiddleware('localeViewPath', \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class);
    }

    protected function registerAdminMenus()
    {
        Event::listen(RouteMatched::class, function () {
            AdminMenu::addItem(__('core::menu.system.index'), [
                'id'    => CoreAdminMenuRegistered::SYSTEM_ROOT_ID,
                'href'  => '#',
                'icon'  => 'fas fa-cogs',
                'order' => 10000,
            ]);

            AdminMenu::addItem(__('core::menu.setting.index'), [
                'id'         => CoreAdminMenuRegistered::SETTING_ID,
                'parent'     => CoreAdminMenuRegistered::SYSTEM_ROOT_ID,
                'route'      => 'core.admin.setting.index',
                'permission' => 'core.admin.setting.index',
                'icon'       => 'fas fa-cog',
                'order'      => 1,
            ]);

            event(CoreAdminMenuRegistered::class);
        });
    }

    protected function bootMailConfig()
    {
        if (setting('mail_driver')) {
            $config = $this->app['config'];

            $defaultConfigMail = $config->get('mail');

            $newConfigMail = [
                'default' => setting('mail_driver') ?? env('MAIL_DRIVER', 'smtp'),
                'mailers' => [
                    'smtp' => [
                        'transport' => 'smtp',
                        'host' => setting('mail_host') ?? env('MAIL_HOST', 'smtp.mailgun.org'),
                        'port' => setting('mail_port') ?? env('MAIL_PORT', 587),
                        'encryption' => setting('mail_encryption') ?? env('MAIL_ENCRYPTION', 'tls'),
                        'username' => setting('mail_username') ?? env('MAIL_USERNAME'),
                        'password' => setting('mail_password') ?? env('MAIL_PASSWORD'),
                    ],
                    'ses' => [
                        'transport' => 'ses',
                    ],
                ],
                'from' => [
                    'address' => setting('mail_address') ?? env('MAIL_FROM_ADDRESS', 'noreply.newnet@gmail.com'),
                    'name' => setting('mail_name') ?? env('MAIL_FROM_NAME', 'Newnet'),
                ],
            ];

            $this->app['config']->set('mail', array_merge($defaultConfigMail, $newConfigMail));

            $defaultConfigService = $config->get('services');

            $newConfigService = [
                'ses' => [
                    'key' => setting('mail_key') ?? env('AWS_ACCESS_KEY_ID'),
                    'secret' => setting('mail_secret') ?? env('AWS_SECRET_ACCESS_KEY'),
                    'region' => setting('mail_region') ?? env('AWS_DEFAULT_REGION', 'us-east-1'),
                ],
            ];

            $this->app['config']->set('services', array_merge($defaultConfigService, $newConfigService));
        }
    }
}
