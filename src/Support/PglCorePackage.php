<?php

namespace Pgl\Core\Support;

use Spatie\LaravelPackageTools\Package;

class PglCorePackage
{
    public static function configure(Package $package): void
    {
        $package
            ->name('pgl-core')
            ->hasConfigFile('pgl-core')
            ->hasViews()
            ->hasMigration('create_pgl_settings_table');
    }
}