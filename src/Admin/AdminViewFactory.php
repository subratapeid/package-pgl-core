<?php

namespace Pgl\Core\Admin;

use Illuminate\Contracts\View\View;
use Pgl\Core\Theme\ThemeResolver;

class AdminViewFactory
{
    public function __construct(
        private readonly ThemeResolver $themeResolver,
        private readonly MenuRegistry $menuRegistry,
    ) {
    }

    public function make(string $view, array $data = []): View
    {
        return view(
            $this->themeResolver->viewOrDefault('admin', $view, "pgl-core::admin.{$view}"),
            array_merge([
                'adminMenuItems' => $this->menuRegistry->items('admin'),
                'adminTheme' => $this->themeResolver->activeOrNull('admin'),
            ], $data),
        );
    }
}