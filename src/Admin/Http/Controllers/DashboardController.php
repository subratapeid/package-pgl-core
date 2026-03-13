<?php

namespace Pgl\Core\Admin\Http\Controllers;

use Illuminate\Contracts\View\View;

class DashboardController extends AdminController
{
    public function index(): View
    {
        return $this->adminView('pages.dashboard', [
            'pageTitle' => 'Dashboard',
        ]);
    }
}