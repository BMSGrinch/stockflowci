@extends('layouts.template')

@section('title', 'Détail mouvement de stock')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Détail du mouvement</h1>
            <p class="text-sm text-slate-500 mt-1">
                Fiche du mouvement de stock n°{{ $stock->id }}.
            </p>
        </div>
        <a href="{{ route('stocks.index') }}"
           class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
            ← Retour vers la liste
        </a>
    </div>
@endsection

@section('content')
    @php
        switch ($stock->movement_type) {
            case 'entry':
                $typeVariant = 'success';
                $typeLabel = 'Entrée';
                $sign = '+';
                $quantityColor = 'text-emerald-600';
                break;
            case 'sale':
                $typeVariant = 'danger';
                $typeLabel = 'Vente';
                $sign = '-';
                $quantityColor = 'text-rose-600';
                break;
            case 'adjustment':
                $typeVariant = 'warning';
                $typeLabel = 'Ajustement';
                $sign = $stock->quantity >= 0 ? '+' : '-';
                $quantityColor = $stock->quantity >= 0 ? 'text-emerald-600' : 'text-rose-600';
                break;
            case 'loss':
            default:
                $typeVariant = 'default';
                $typeLabel = 'Perte';
                $sign = '-';
                $quantityColor = 'text-slate-600';
                break;
        }
        $absoluteQuantity = abs($stock->quantity);
    @endphp

    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
        <dl class="divide-y divide-slate-100">
            <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Produit</dt>
                <dd class="mt-1 text-sm font-medium text-slate-900 sm:col-span-2 sm:mt-0">
                    {{ optional($stock->product)->name ?? '—' }}
                    @if(optional($stock->product)->reference)
                        <span class="font-mono text-slate-500">({{ $stock->product->reference }})</span>
                    @endif
                </dd>
            </div>
            <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Type de mouvement</dt>
                <dd class="mt-1 sm:col-span-2 sm:mt-0">
                    <x-badges :variant="$typeVariant">{{ $typeLabel }}</x-badges>
                </dd>
            </div>
            <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Quantité</dt>
                <dd class="mt-1 text-sm font-semibold {{ $quantityColor }} sm:col-span-2 sm:mt-0">
                    {{ $sign }}{{ $absoluteQuantity }}
                </dd>
            </div>
            <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Utilisateur</dt>
                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                    {{ optional($stock->user)->name ?? '—' }}
                </dd>
            </div>
            <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Date</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    {{ optional($stock->created_at)->format('d/m/Y à H:i') ?? '—' }}
                </dd>
            </div>
            <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Note</dt>
                <dd class="mt-1 text-sm text-slate-600 sm:col-span-2 sm:mt-0">
                    {{ $stock->note ?: '—' }}
                </dd>
            </div>
        </dl>

        <div class="border-t border-slate-100 bg-slate-50/50 px-6 py-3">
            <a href="{{ route('stocks.index') }}"
               class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900">
                ← Retour vers la liste
            </a>
        </div>
    </div>
@endsection
