<?php

namespace Pgl\Core\Admin\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class UploadMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:120'],
            'file' => ['required', 'file', 'max:'.config('pgl-core.media.max_upload_kb', 10240)],
        ];
    }
}