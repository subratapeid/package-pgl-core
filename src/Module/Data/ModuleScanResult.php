<?php

namespace Pgl\Core\Module\Data;

readonly class ModuleScanResult
{
    /**
     * @param array<string, ModuleManifest> $manifests
     * @param array<int, string> $duplicateKeys
     * @param array<string, array<int, string>> $missingDependencies
     * @param array<int, string> $orderedKeys
     * @param array<int, string> $orderingIssues
     */
    public function __construct(
        public array $manifests,
        public array $duplicateKeys,
        public array $missingDependencies,
        public array $orderedKeys,
        public array $orderingIssues = [],
    ) {
    }

    public function isBootable(): bool
    {
        return $this->duplicateKeys === []
            && $this->missingDependencies === []
            && $this->orderingIssues === [];
    }
}
