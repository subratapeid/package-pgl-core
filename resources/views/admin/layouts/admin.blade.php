<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        <aside class="w-72 bg-[var(--sidebar-background)] px-6 py-8 text-[var(--sidebar-foreground)]">
            <div class="mb-10">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-300">Platform</p>
                <h1 class="mt-2 text-2xl font-semibold">{{ config('app.name') }}</h1>
                <p class="mt-2 text-sm text-slate-300">Admin theme: {{ $adminTheme?->key ?? 'core-default' }}</p>
            </div>

            <nav class="space-y-2">
                @foreach ($adminMenuItems as $item)
                    <a
                        href="{{ route($item->route) }}"
                        class="block rounded-lg px-4 py-3 text-sm font-medium transition hover:bg-white/10"
                    >
                        {{ $item->label }}
                    </a>
                @endforeach
            </nav>
        </aside>

        <main class="flex-1">
            <header class="border-b border-[var(--panel-border)] bg-white/80 px-8 py-5 backdrop-blur">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-[var(--text-muted)]">Admin</p>
                        <h2 class="mt-1 text-2xl font-semibold">{{ $pageTitle ?? 'Dashboard' }}</h2>
                    </div>
                    <div class="rounded-full bg-[var(--accent-soft)] px-4 py-2 text-sm text-[var(--accent)]">
                        Core package
                    </div>
                </div>
            </header>

            <section class="p-8">
                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>