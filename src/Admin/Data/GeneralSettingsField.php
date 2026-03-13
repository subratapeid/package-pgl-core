<?php

namespace Pgl\Core\Admin\Data;

readonly class GeneralSettingsField
{
    /**
     * @param array<int, mixed> $rules
     */
    public function __construct(
        public string $key,
        public string $label,
        public array $rules = [],
        public string $type = 'text',
        public mixed $defaultValue = null,
        public ?string $placeholder = null,
        public ?string $helpText = null,
        public int $order = 100,
    ) {
    }
}