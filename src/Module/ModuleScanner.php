<?php

namespace Pgl\Core\Module;

use Illuminate\Contracts\Config\Repository;
use Pgl\Core\Module\Data\ModuleManifest;
use Pgl\Core\Module\Data\ModuleScanResult;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

class ModuleScanner
{
    public function __construct(
        private readonly Repository $config,
        private readonly ModuleManifestParser $manifestParser,
        private readonly ModuleDependencyResolver $dependencyResolver,
    ) {
    }

    public function scan(): ModuleScanResult
    {
        $manifests = [];
        $duplicateKeys = [];

        foreach ($this->manifestFiles() as $manifestPath) {
            $manifest = $this->manifestParser->parse($manifestPath);

            if (isset($manifests[$manifest->key])) {
                $duplicateKeys[] = $manifest->key;
                continue;
            }

            $manifests[$manifest->key] = $manifest;
        }

        $missingDependencies = $this->missingDependencies($manifests);
        $orderedKeys = [];
        $orderingIssues = [];

        try {
            $orderedKeys = $this->dependencyResolver->order($manifests);
        } catch (RuntimeException $exception) {
            $orderingIssues[] = $exception->getMessage();
        }

        return new ModuleScanResult(
            manifests: $manifests,
            duplicateKeys: array_values(array_unique($duplicateKeys)),
            missingDependencies: $missingDependencies,
            orderedKeys: $orderedKeys,
            orderingIssues: $orderingIssues,
        );
    }

    /**
     * @return array<int, string>
     */
    private function manifestFiles(): array
    {
        $manifestFiles = [];

        foreach ((array) $this->config->get('pgl-core.module_paths', []) as $modulePath) {
            if (! is_string($modulePath) || ! is_dir($modulePath)) {
                continue;
            }

            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($modulePath, RecursiveDirectoryIterator::SKIP_DOTS),
            );

            foreach ($iterator as $fileInfo) {
                if ($fileInfo->isFile() && $fileInfo->getFilename() === 'module.json') {
                    $manifestFiles[] = $fileInfo->getPathname();
                }
            }
        }

        sort($manifestFiles);

        return $manifestFiles;
    }

    /**
     * @param array<string, ModuleManifest> $manifests
     * @return array<string, array<int, string>>
     */
    private function missingDependencies(array $manifests): array
    {
        $missing = [];

        foreach ($manifests as $manifest) {
            foreach ($manifest->dependsOnModules as $dependencyKey) {
                if (! isset($manifests[$dependencyKey])) {
                    $missing[$manifest->key][] = $dependencyKey;
                }
            }
        }

        return $missing;
    }
}
