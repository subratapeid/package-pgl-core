<?php

namespace Pgl\Core\Admin\Services;

use Pgl\Core\Admin\GeneralSettingsFieldRegistry;
use Pgl\Core\Settings\SettingsManager;

class GeneralSettingsService
{
    public function __construct(
        private readonly SettingsManager $settingsManager,
        private readonly GeneralSettingsFieldRegistry $fieldRegistry,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function general(): array
    {
        return array_merge(
            $this->fieldRegistry->defaults(),
            $this->settingsManager->group('general'),
        );
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function update(array $payload): void
    {
        $this->settingsManager->setGroup('general', $payload);
    }
}