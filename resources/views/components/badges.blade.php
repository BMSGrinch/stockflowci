@props([
    'variant' => 'default', // default, success, warning, danger
])

@php
    $baseClasses = 'inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-medium';

    $variants = [
        'default' => 'bg-slate-800/70 text-slate-100 border border-slate-700',
        'success' => 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/40',
        'warning' => 'bg-amber-500/10 text-amber-300 border border-amber-500/40',
        'danger'  => 'bg-rose-500/10 text-rose-300 border border-rose-500/40',
    ];

    $classes = $baseClasses.' '.($variants[$variant] ?? $variants['default']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>

