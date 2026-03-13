<?php

namespace Pgl\Core\Module;

use InvalidArgumentException;
use JsonException;
use Pgl\Core\Module\Data\ModuleManifest;

class ModuleManifestParser
{
    public function parse(string $manifestPath): ModuleManifest
    {
        try {
            $decoded = json_decode((string) file_get_contents($manifestPath), true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new InvalidArgumentException("Invalid module manifest JSON at [{$manifestPath}].", previous: $exception);
        }

        if (! is_array($decoded)) {
            throw new InvalidArgumentException("Invalid module manifest at [{$manifestPath}].");
        }

        foreach (['key', 'name', 'version', 'type'] as $requiredField) {
            if (! isset($decoded[$requiredField]) || ! is_string($decoded[$requiredField]) || $decoded[$requiredField] === '') {
                throw new InvalidArgumentException("Module manifest [{$manifestPath}] is missing required field [{$requiredField}].");
            }
        }

        return new ModuleManifest(
            key: $decoded['key'],
            name: $decoded['name'],
            version: $decoded['version'],
            type: $decoded['type'],
            dependsOnModules: $this->stringList($decoded['depends_on_modules'] ?? []),
            providers: $this->stringList($decoded['providers'] ?? []),
            routes: $this->stringList($decoded['routes'] ?? []),
            migrations: $this->stringList($decoded['migrations'] ?? []),
            enabledByDefault: (bool) ($decoded['enabled_by_default'] ?? true),
            basePath: dirname($manifestPath),
            manifestPath: $manifestPath,
        );
    }

    /**
     * @param mixed $value
     * @return array<int, string>
     */
    private function stringList(mixed $value): array
    {
        if (! is_array($value)) {
            throw new InvalidArgumentException('Module manifest array fields must be arrays of strings.');
        }

        $strings = [];

        foreach ($value as $item) {
            if (! is_string($item) || $item === '') {
                throw new InvalidArgumentException('Module manifest array fields must be arrays of strings.');
            }

            $strings[] = $item;
        }

        return $strings;
    }
}
