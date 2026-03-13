<?php

namespace Pgl\Core\Theme;

class ThemeRegistry
{
    /**
     * @var array<string, array<string, ThemeDefinition>>
     */
    private array $themes = [];

    public function register(ThemeDefinition $theme): void
    {
        $this->themes[$theme->area][$theme->key] = $theme;
    }

    public function get(string $area, string $key): ?ThemeDefinition
    {
        return $this->themes[$area][$key] ?? null;
    }

    /**
     * @return array<int, ThemeDefinition>
     */
    public function all(string $area): array
    {
        return array_values($this->themes[$area] ?? []);
    }
}
