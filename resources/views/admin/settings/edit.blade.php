@extends('pgl-core::admin.layouts.admin')

@section('content')
    <div class="max-w-3xl rounded-2xl border border-[var(--panel-border)] bg-[var(--panel-background)] p-6 shadow-sm">
        <div class="mb-6">
            <h3 class="text-lg font-semibold">General settings</h3>
            <p class="mt-2 text-sm text-[var(--text-muted)]">
                Core fields and project-specific fields can live together here without editing package views each time.
            </p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="post" class="space-y-5">
            @csrf
            @method('PUT')

            @foreach ($settingFields as $field)
                <label class="block">
                    <span class="mb-2 block text-sm font-medium">{{ $field->label }}</span>

                    @if ($field->type === 'textarea')
                        <textarea
                            name="{{ $field->key }}"
                            class="w-full rounded-xl border border-[var(--panel-border)] px-4 py-3"
                            placeholder="{{ $field->placeholder }}"
                            rows="4"
                        >{{ old($field->key, $settings[$field->key] ?? $field->defaultValue) }}</textarea>
                    @else
                        <input
                            type="{{ $field->type }}"
                            name="{{ $field->key }}"
                            value="{{ old($field->key, $settings[$field->key] ?? $field->defaultValue) }}"
                            class="w-full rounded-xl border border-[var(--panel-border)] px-4 py-3"
                            placeholder="{{ $field->placeholder }}"
                        >
                    @endif

                    @if ($field->helpText)
                        <span class="mt-2 block text-sm text-[var(--text-muted)]">{{ $field->helpText }}</span>
                    @endif

                    @error($field->key)
                        <span class="mt-2 block text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            @endforeach

            <button
                type="submit"
                class="rounded-xl bg-[var(--accent)] px-5 py-3 text-sm font-medium text-white"
            >
                Save settings
            </button>
        </form>
    </div>
@endsection