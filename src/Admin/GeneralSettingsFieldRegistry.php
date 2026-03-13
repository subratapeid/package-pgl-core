<?php

namespace Pgl\Core\Admin;

use Pgl\Core\Admin\Data\GeneralSettingsField;

class GeneralSettingsFieldRegistry
{
    /**
     * @var array<string, GeneralSettingsField>
     */
    private array $fields = [];

    public function register(GeneralSettingsField $field): void
    {
        $this->fields[$field->key] = $field;

        uasort($this->fields, static function (GeneralSettingsField $left, GeneralSettingsField $right): int {
            return [$left->order, $left->label] <=> [$right->order, $right->label];
        });
    }

    /**
     * @return array<int, GeneralSettingsField>
     */
    public function all(): array
    {
        return array_values($this->fields);
    }

    /**
     * @return array<string, mixed>
     */
    public function defaults(): array
    {
        $defaults = [];

        foreach ($this->fields as $field) {
            $defaults[$field->key] = $field->defaultValue;
        }

        return $defaults;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $rules = [];

        foreach ($this->fields as $field) {
            $rules[$field->key] = $field->rules;
        }

        return $rules;
    }
}