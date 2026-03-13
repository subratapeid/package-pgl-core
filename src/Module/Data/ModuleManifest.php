<?php

namespace Pgl\Core\Module\Data;

readonly class ModuleManifest
{
    /**
     * @param array<int, string> $dependsOnModules
     * @param array<int, string> $providers
     * @param array<int, string> $routes
     * @param array<int, string> $migrations
     */
    public function __construct(
        public string $key,
        public string $name,
        public string $version,
        public string $type,
        public array $dependsOnModules,
        public array $providers,
        public array $routes,
        public array $migrations,
        public bool $enabledByDefault,
        public string $basePath,
        public string $manifestPath,
    ) {
    }
}
