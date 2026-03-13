<?php

namespace Pgl\Core\Admin;

use Pgl\Core\Admin\Data\MenuItem;

class MenuRegistry
{
    /**
     * @var array<string, array<string, MenuItem>>
     */
    private array $items = [];

    public function register(string $area, MenuItem $item): void
    {
        $this->items[$area][$item->key] = $item;

        uasort($this->items[$area], static function (MenuItem $left, MenuItem $right): int {
            return [$left->order, $left->label] <=> [$right->order, $right->label];
        });
    }

    /**
     * @return array<int, MenuItem>
     */
    public function items(string $area): array
    {
        return array_values($this->items[$area] ?? []);
    }
}
