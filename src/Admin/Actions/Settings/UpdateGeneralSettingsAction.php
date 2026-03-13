<?php

namespace Pgl\Core\Admin\Actions\Settings;

use Pgl\Core\Admin\Services\GeneralSettingsService;

class UpdateGeneralSettingsAction
{
    public function __construct(
        private readonly GeneralSettingsService $settingsService,
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function __invoke(array $payload): void
    {
        $this->settingsService->update($payload);
    }
}