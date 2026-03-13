<?php

namespace Pgl\Core;

use DirectoryIterator;
use Illuminate\Support\Facades\View;
use Pgl\Core\Admin\AdminViewFactory;
use Pgl\Core\Admin\Data\GeneralSettingsField;
use Pgl\Core\Admin\Data\MenuItem;
use Pgl\Core\Admin\GeneralSettingsFieldRegistry;
use Pgl\Core\Admin\MenuRegistry;
use Pgl\Core\Media\Contracts\MediaDriver;
use Pgl\Core\Media\MediaManager;
use Pgl\Core\Media\SpatieMediaDriver;
use Pgl\Core\Module\ModuleBootstrapper;
use Pgl\Core\Module\ModuleDependencyResolver;
use Pgl\Core\Module\ModuleManifestParser;
use Pgl\Core\Module\ModuleScanner;
use Pgl\Core\Settings\SettingsManager;
use Pgl\Core\Support\PglCorePackage;
use Pgl\Core\Theme\ThemeDefinition;
use Pgl\Core\Theme\ThemeRegistry;
use Pgl\Core\Theme\ThemeResolver;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PglCoreServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        PglCorePackage::configure($package);
    }

    public function registeringPackage(): void
    {
        $this->app->singleton(AdminViewFactory::class);
        $this->app->singleton(GeneralSettingsFieldRegistry::class);
        $this->app->singleton(MenuRegistry::class);
        $this->app->singleton(ThemeRegistry::class);
        $this->app->singleton(ThemeResolver::class);
        $this->app->singleton(ModuleManifestParser::class);
        $this->app->singleton(ModuleDependencyResolver::class);
        $this->app->singleton(ModuleScanner::class);
        $this->app->singleton(ModuleBootstrapper::class);
        $this->app->singleton(SettingsManager::class);
        $this->app->singleton(MediaDriver::class, SpatieMediaDriver::class);
        $this->app->singleton(MediaManager::class);
    }

    public function bootingPackage(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        config()->set('media-library.disk_name', config('pgl-core.media.disk', 'media'));

        $this->registerDefaultAdminMenu();
        $this->registerDefaultGeneralSettingsFields();
        $this->registerThemeNamespaces();

        if (config('pgl-core.bootstrap_modules', true)) {
            $this->app->make(ModuleBootstrapper::class)->boot();
        }
    }

    private function registerDefaultAdminMenu(): void
    {
        $menuRegistry = $this->app->make(MenuRegistry::class);

        $menuRegistry->register('admin', new MenuItem(
            key: 'core.dashboard',
            label: 'Dashboard',
            route: 'admin.dashboard',
            icon: 'home',
            order: 100,
        ));

        $menuRegistry->register('admin', new MenuItem(
            key: 'core.settings',
            label: 'Settings',
            route: 'admin.settings.edit',
            icon: 'sliders',
            order: 200,
        ));

        $menuRegistry->register('admin', new MenuItem(
            key: 'core.media',
            label: 'Media Library',
            route: 'admin.media.index',
            icon: 'image',
            order: 250,
        ));
    }

    private function registerDefaultGeneralSettingsFields(): void
    {
        $registry = $this->app->make(GeneralSettingsFieldRegistry::class);

        $registry->register(new GeneralSettingsField(
            key: 'site_name',
            label: 'Site name',
            rules: ['required', 'string', 'max:120'],
            defaultValue: config('app.name'),
            order: 100,
        ));

        $registry->register(new GeneralSettingsField(
            key: 'support_email',
            label: 'Support email',
            rules: ['nullable', 'email', 'max:120'],
            type: 'email',
            defaultValue: null,
            order: 200,
        ));
    }

    private function registerThemeNamespaces(): void
    {
        $themeRegistry = $this->app->make(ThemeRegistry::class);

        foreach ((array) config('pgl-core.themes.areas', []) as $area => $configuration) {
            $basePath = $configuration['path'] ?? null;

            if (! is_string($basePath) || ! is_dir($basePath)) {
                continue;
            }

            foreach (new DirectoryIterator($basePath) as $directory) {
                if ($directory->isDot() || ! $directory->isDir()) {
                    continue;
                }

                $key = $directory->getBasename();
                $namespace = "theme-{$area}-{$key}";
                $themePath = $directory->getPathname();

                $themeRegistry->register(new ThemeDefinition(
                    area: $area,
                    key: $key,
                    path: $themePath,
                    namespace: $namespace,
                ));

                $viewsPath = $themePath.DIRECTORY_SEPARATOR.'views';

                if (is_dir($viewsPath)) {
                    View::addNamespace($namespace, $viewsPath);
                }
            }
        }
    }
}