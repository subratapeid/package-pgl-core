@extends('pgl-core::admin.layouts.admin')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[360px_1fr]">
        <section class="rounded-2xl border border-[var(--panel-border)] bg-[var(--panel-background)] p-6 shadow-sm">
            <h3 class="text-lg font-semibold">Upload file</h3>
            <p class="mt-2 text-sm text-[var(--text-muted)]">
                The default media manager ships with <code>pgl/core</code> so every project gets the same upload workflow.
            </p>

            <form action="{{ route('admin.media.store') }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf

                <label class="block">
                    <span class="mb-2 block text-sm font-medium">Display name</span>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full rounded-xl border border-[var(--panel-border)] px-4 py-3"
                        placeholder="Homepage hero image"
                    >
                    @error('name')
                        <span class="mt-2 block text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium">File</span>
                    <input
                        type="file"
                        name="file"
                        class="w-full rounded-xl border border-[var(--panel-border)] px-4 py-3"
                    >
                    @error('file')
                        <span class="mt-2 block text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </label>

                <button
                    type="submit"
                    class="rounded-xl bg-[var(--accent)] px-5 py-3 text-sm font-medium text-white"
                >
                    Upload media
                </button>
            </form>
        </section>

        <section class="rounded-2xl border border-[var(--panel-border)] bg-[var(--panel-background)] p-6 shadow-sm">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Library</h3>
                    <p class="mt-2 text-sm text-[var(--text-muted)]">Uploaded assets are stored on the dedicated media disk.</p>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ count($mediaItems) }} items</span>
            </div>

            <div class="grid gap-4 md:grid-cols-2 2xl:grid-cols-3">
                @forelse ($mediaItems as $item)
                    <article class="overflow-hidden rounded-2xl border border-[var(--panel-border)] bg-white">
                        <div class="flex h-48 items-center justify-center bg-slate-100">
                            @if ($item->isImage)
                                <img src="{{ $item->url }}" alt="{{ $item->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-white">
                                    {{ strtoupper(pathinfo($item->fileName, PATHINFO_EXTENSION) ?: 'FILE') }}
                                </div>
                            @endif
                        </div>

                        <div class="space-y-3 p-4">
                            <div>
                                <h4 class="font-semibold">{{ $item->name }}</h4>
                                <p class="mt-1 text-sm text-[var(--text-muted)]">{{ $item->fileName }}</p>
                            </div>

                            <div class="text-xs text-[var(--text-muted)]">
                                <p>{{ $item->mimeType ?? 'Unknown type' }}</p>
                                <p>{{ number_format($item->size / 1024, 1) }} KB</p>
                                <p>{{ $item->createdAt }}</p>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                <a href="{{ $item->url }}" target="_blank" class="text-sm font-medium text-[var(--accent)]">
                                    Open file
                                </a>

                                <form action="{{ route('admin.media.destroy', $item->assetId) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-rose-600">Delete</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-[var(--panel-border)] px-6 py-12 text-center text-sm text-[var(--text-muted)] md:col-span-2 2xl:col-span-3">
                        No media uploaded yet.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection