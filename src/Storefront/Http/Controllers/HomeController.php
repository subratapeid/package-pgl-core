<?php

namespace Pgl\Core\Storefront\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Pgl\Core\Theme\ThemeResolver;

class HomeController extends Controller
{
    public function __construct(
        private readonly ThemeResolver $themeResolver,
    ) {
    }

    public function __invoke(): View
    {
        return view($this->themeResolver->viewOrDefault('storefront', 'pages.home', 'pgl-core::storefront.pages.home'), [
            'pageTitle' => 'Storefront',
        ]);
    }
}