@extends('pgl-core::admin.layouts.admin')

@section('content')
    <div class="mb-6">
        @include('pgl-core::components.platform-badge')
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        <section class="rounded-2xl border border-[var(--panel-border)] bg-[var(--panel-background)] p-6 shadow-sm">
            <p class="text-sm text-[var(--text-muted)]">Platform core</p>
            <h3 class="mt-3 text-xl font-semibold">Package-first foundation</h3>
            <p class="mt-3 text-sm leading-6 text-[var(--text-muted)]">
                This admin area is delivered directly from <code>pgl/core</code>, so every project starts from the same base.
            </p>
        </section>

        <section class="rounded-2xl border border-[var(--panel-border)] bg-[var(--panel-background)] p-6 shadow-sm">
            <p class="text-sm text-[var(--text-muted)]">Domain ready</p>
            <h3 class="mt-3 text-xl font-semibold">Composable packages</h3>
            <p class="mt-3 text-sm leading-6 text-[var(--text-muted)]">
                Business modules like <code>pgl/ecommerce</code> and <code>pgl/inventory</code> can extend this shell without moving code into the host app.
            </p>
        </section>

        <section class="rounded-2xl border border-[var(--panel-border)] bg-[var(--panel-background)] p-6 shadow-sm">
            <p class="text-sm text-[var(--text-muted)]">Customization layer</p>
            <h3 class="mt-3 text-xl font-semibold">Thin Laravel host</h3>
            <p class="mt-3 text-sm leading-6 text-[var(--text-muted)]">
                Keep the app for storefront themes, client-specific flows, and integrations. Shared backend behavior stays in packages.
            </p>
        </section>
    </div>
@endsection