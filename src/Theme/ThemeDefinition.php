<?php

namespace Pgl\Core\Theme;

readonly class ThemeDefinition
{
    public function __construct(
        public string $area,
        public string $key,
        public string $path,
        public string $namespace,
    ) {
    }
}
