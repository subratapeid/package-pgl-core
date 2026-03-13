<?php

namespace Pgl\Core\Admin\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Pgl\Core\Admin\Actions\Settings\UpdateGeneralSettingsAction;
use Pgl\Core\Admin\AdminViewFactory;
use Pgl\Core\Admin\GeneralSettingsFieldRegistry;
use Pgl\Core\Admin\Http\Requests\Settings\UpdateGeneralSettingsRequest;
use Pgl\Core\Admin\Services\GeneralSettingsService;

class SettingsController extends AdminController
{
    public function __construct(
        AdminViewFactory $adminViewFactory,
        private readonly GeneralSettingsService $settingsService,
        private readonly GeneralSettingsFieldRegistry $fieldRegistry,
        private readonly UpdateGeneralSettingsAction $updateGeneralSettingsAction,
    ) {
        parent::__construct($adminViewFactory);
    }

    public function edit(): View
    {
        return $this->adminView('settings.edit', [
            'pageTitle' => 'Settings',
            'settingFields' => $this->fieldRegistry->all(),
            'settings' => $this->settingsService->general(),
        ]);
    }

    public function update(UpdateGeneralSettingsRequest $request): RedirectResponse
    {
        ($this->updateGeneralSettingsAction)($request->validated());

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Settings updated.');
    }
}