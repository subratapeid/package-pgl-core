<?php

namespace Pgl\Core\Theme;

use Illuminate\Contracts\Config\Repository;
use RuntimeException;

class ThemeResolver
{
    public function __construct(
        private readonly Repository $config,
        private readonly ThemeRegistry $themeRegistry,
    ) {
    }

    public function activeOrNull(string $area): ?ThemeDefinition
    {
        $activeTheme = (string) $this->config->get("pgl-core.themes.areas.{$area}.active", 'default');

        return $this->themeRegistry->get($area, $activeTheme);
    }

    public function active(string $area): ThemeDefinition
    {
        $theme = $this->activeOrNull($area);

        if ($theme === null) {
            $activeTheme = (string) $this->config->get("pgl-core.themes.areas.{$area}.active", 'default');

            throw new RuntimeException("The active [{$area}] theme [{$activeTheme}] is not registered.");
        }

        return $theme;
    }

    public function view(string $area, string $view): string
    {
        return $this->active($area)->namespace.'::'.$view;
    }

    public function viewOrDefault(string $area, string $view, string $fallbackView): string
    {
        $theme = $this->activeOrNull($area);

        if ($theme === null) {
            return $fallbackView;
        }

        return $theme->namespace.'::'.$view;
    }

    public function path(string $area, string $suffix = ''): string
    {
        $path = $this->active($area)->path;

        if ($suffix === '') {
            return $path;
        }

        return $path.DIRECTORY_SEPARATOR.ltrim($suffix, DIRECTORY_SEPARATOR);
    }
}