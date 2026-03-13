<?php

namespace Pgl\Core\Admin\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Pgl\Core\Admin\AdminViewFactory;

abstract class AdminController extends Controller
{
    public function __construct(
        private readonly AdminViewFactory $adminViewFactory,
    ) {
    }

    protected function adminView(string $view, array $data = []): View
    {
        return $this->adminViewFactory->make($view, $data);
    }
}