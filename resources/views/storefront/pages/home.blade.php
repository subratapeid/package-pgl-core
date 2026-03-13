@extends('pgl-core::storefront.layouts.storefront')

@section('content')
    <div class="grid gap-10 lg:grid-cols-[1.3fr_0.7fr]">
        <section>
            <p class="text-sm uppercase tracking-[0.35em] text-sky-300">Package storefront</p>
            <h1 class="mt-5 text-5xl font-semibold leading-tight">
                A reusable platform starter that boots from <code>pgl/core</code>.
            </h1>
            <p class="mt-6 max-w-2xl text-lg text-slate-300">
                The Laravel app can stay almost empty by default. Add project themes or client-specific UI only when a customer needs them.
            </p>
        </section>

        <section class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-sky-950/30">
            <p class="text-sm text-slate-300">Prepared modules</p>
            <ul class="mt-4 space-y-3 text-sm text-slate-100">
                <li><code>pgl/core</code> for shared platform concerns</li>
                <li><code>pgl/ecommerce</code> for domain features</li>
                <li>Optional app themes and client overrides</li>
            </ul>
        </section>
    </div>
@endsection