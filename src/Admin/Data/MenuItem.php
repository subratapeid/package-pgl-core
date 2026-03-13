<?php

namespace Pgl\Core\Admin\Data;

readonly class MenuItem
{
    public function __construct(
        public string $key,
        public string $label,
        public string $route,
        public string $icon = 'square',
        public int $order = 100,
    ) {
    }
}
