<?php

namespace Pgl\Core\Module;

use Illuminate\Contracts\Foundation\Application;
use Pgl\Core\Module\Data\ModuleScanResult;

class ModuleBootstrapper
{
    public function __construct(
        private readonly Application $app,
        private readonly ModuleScanner $moduleScanner,
    ) {
    }

    public function boot(): ModuleScanResult
    {
        $scanResult = $this->moduleScanner->scan();

        if (! $scanResult->isBootable()) {
            return $scanResult;
        }

        foreach ($scanResult->orderedKeys as $moduleKey) {
            $manifest = $scanResult->manifests[$moduleKey];

            if (! $manifest->enabledByDefault) {
                continue;
            }

            foreach ($manifest->providers as $providerClass) {
                if (! class_exists($providerClass)) {
                    continue;
                }

                if (method_exists($this->app, 'getProvider') && $this->app->getProvider($providerClass) !== null) {
                    continue;
                }

                $this->app->register($providerClass);
            }
        }

        return $scanResult;
    }
}
