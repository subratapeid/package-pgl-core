<?php

namespace Pgl\Core\Admin\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Pgl\Core\Admin\GeneralSettingsFieldRegistry;

class UpdateGeneralSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return app(GeneralSettingsFieldRegistry::class)->rules();
    }
}