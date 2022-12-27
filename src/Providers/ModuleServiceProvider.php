<?php

namespace Newnet\Core\Providers;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Newnet\Core\Services\ModuleManager\ModuleLoader;

class ModuleServiceProvider extends ServiceProvider
{
    protected $providers = [];

    public function boot()
    {
        $this->registerModules();
        $this->registerProviders();
    }

    protected function registerModules()
    {
        $modules = ModuleLoader::getEnabledModules();

        $composerLoader = new ClassLoader();
        foreach ($modules as $key => $enable) {
            if ($enable) {
                $moduleDefineFile = $this->getModuleFilePath($key, 'module.json');

                if (!File::exists($moduleDefineFile)) {
                    continue;
                }

                $moduleDefineContent = json_decode(File::get($moduleDefineFile), true);

                if (!preg_match('/^vendor/', $key)) {
                    $namespace = $moduleDefineContent['namespace'];
                    $srcPath = $this->getModuleFilePath($key, 'src');
                    $composerLoader->setPsr4($namespace, $srcPath);
                }

                if (isset($moduleDefineContent['providers'])) {
                    $this->providers = array_merge($this->providers, $moduleDefineContent['providers']);
                }
            }
        }
        $composerLoader->register();
    }

    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            if (class_exists($provider)) {
                $this->app->register($provider);
            }
        }
    }

    protected function getModuleDir($moduleKey)
    {
        $moduleBasePath = preg_match('/^vendor/', $moduleKey) ? base_path('') : base_path('modules');

        return $moduleBasePath . DIRECTORY_SEPARATOR . $moduleKey;
    }

    protected function getModuleFilePath($moduleKey, $filePath)
    {
        return $this->getModuleDir($moduleKey) . DIRECTORY_SEPARATOR . $filePath;
    }
}
