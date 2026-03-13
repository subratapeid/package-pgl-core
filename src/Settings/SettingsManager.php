<?php

namespace Pgl\Core\Settings;

use JsonException;
use Pgl\Core\Settings\Models\Setting;

class SettingsManager
{
    /**
     * @return array<string, mixed>
     */
    public function group(string $group): array
    {
        return Setting::query()
            ->where('group', $group)
            ->get()
            ->mapWithKeys(fn (Setting $setting): array => [$setting->key => $this->decode($setting->value)])
            ->all();
    }

    /**
     * @param array<string, mixed> $values
     */
    public function setGroup(string $group, array $values): void
    {
        foreach ($values as $key => $value) {
            Setting::query()->updateOrCreate(
                ['group' => $group, 'key' => $key],
                ['value' => $this->encode($value)],
            );
        }
    }

    private function encode(mixed $value): string
    {
        try {
            return json_encode($value, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new \InvalidArgumentException('Unable to encode the setting value.', previous: $exception);
        }
    }

    private function decode(?string $value): mixed
    {
        if ($value === null) {
            return null;
        }

        try {
            return json_decode($value, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            return $value;
        }
    }
}
