<?php

namespace Pgl\Core\Module;

use Pgl\Core\Module\Data\ModuleManifest;
use RuntimeException;

class ModuleDependencyResolver
{
    /**
     * @param array<string, ModuleManifest> $manifests
     * @return array<int, string>
     */
    public function order(array $manifests): array
    {
        $ordered = [];
        $visited = [];
        $visiting = [];

        foreach ($manifests as $key => $manifest) {
            $this->visit($key, $manifest, $manifests, $ordered, $visited, $visiting);
        }

        return $ordered;
    }

    /**
     * @param array<string, ModuleManifest> $manifests
     * @param array<int, string> $ordered
     * @param array<string, bool> $visited
     * @param array<string, bool> $visiting
     */
    private function visit(
        string $key,
        ModuleManifest $manifest,
        array $manifests,
        array &$ordered,
        array &$visited,
        array &$visiting,
    ): void {
        if (isset($visited[$key])) {
            return;
        }

        if (isset($visiting[$key])) {
            throw new RuntimeException("Circular module dependency detected for [{$key}].");
        }

        $visiting[$key] = true;

        foreach ($manifest->dependsOnModules as $dependencyKey) {
            if (! isset($manifests[$dependencyKey])) {
                continue;
            }

            $this->visit($dependencyKey, $manifests[$dependencyKey], $manifests, $ordered, $visited, $visiting);
        }

        unset($visiting[$key]);
        $visited[$key] = true;
        $ordered[] = $key;
    }
}
