@extends('layouts.template')

@section('title', 'Détails du produit')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">
                {{ $product->name }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Référence {{ $product->reference }} · Fiche produit
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('products.edit', $product) }}"
               class="inline-flex items-center gap-2 rounded-full border border-emerald-300 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 hover:bg-emerald-100 transition">
                Modifier le produit
            </a>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                Retour à la liste
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid gap-4 lg:grid-cols-3">
        {{-- Fiche produit --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5">
                <h2 class="text-sm font-semibold text-slate-900 mb-4">Informations générales</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Nom</dt>
                        <dd class="text-slate-900">{{ $product->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Référence</dt>
                        <dd class="font-mono text-xs text-slate-800">{{ $product->reference }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Catégorie</dt>
                        <dd class="text-slate-900">{{ $product->category ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Fournisseur</dt>
                        <dd class="text-slate-900">
                            {{ optional($product->supplier)->name ?? '—' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5">
                <h2 class="text-sm font-semibold text-slate-900 mb-4">Prix et stock</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Prix d&apos;achat</dt>
                        <dd class="text-slate-900">
                            {{ number_format($product->purchase_price, 0, ',', ' ') }} FCFA
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Prix de vente</dt>
                        <dd class="text-slate-900">
                            {{ number_format($product->selling_price, 0, ',', ' ') }} FCFA
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Stock actuel</dt>
                        <dd class="text-slate-900 font-semibold">
                            {{ $product->quantity }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Seuil d&apos;alerte</dt>
                        <dd class="text-slate-900">
                            {{ $product->alert_threshold }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Statut et mouvements récents --}}
        <div class="space-y-4">
            {{-- Statut --}}
            <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5">
                <h2 class="text-sm font-semibold text-slate-900 mb-3">Statut</h2>
                @php
                    $quantity = $product->quantity ?? 0;
                    $threshold = $product->alert_threshold ?? 0;

                    if ($quantity <= 0) {
                        $statusVariant = 'danger';
                        $statusLabel = 'Rupture';
                    } elseif ($quantity <= $threshold) {
                        $statusVariant = 'warning';
                        $statusLabel = 'Stock faible';
                    } else {
                        $statusVariant = 'success';
                        $statusLabel = 'En stock';
                    }
                @endphp
                <div class="flex items-center gap-2">
                    <x-badges :variant="$statusVariant">
                        {{ $statusLabel }}
                    </x-badges>
                    @if($product->is_active)
                        <span class="text-xs text-emerald-600">Produit actif</span>
                    @else
                        <span class="text-xs text-slate-500">Produit inactif</span>
                    @endif
                </div>
            </div>

            {{-- Derniers mouvements --}}
            <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5">
                <h2 class="text-sm font-semibold text-slate-900 mb-3">Derniers mouvements de stock</h2>
                <div class="overflow-x-auto -mx-3 sm:mx-0">
                    <table class="min-w-full divide-y divide-slate-200 text-xs sm:text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                    Date
                                </th>
                                <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                    Type
                                </th>
                                <th class="px-3 py-2 text-center font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                    Quantité
                                </th>
                                <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                    Utilisateur
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @php
                                $movements = $product->StockMovements ?? collect();
                                $movements = $movements->sortByDesc('created_at')->take(10);
                            @endphp

                            @forelse($movements as $movement)
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-3 py-2 whitespace-nowrap text-slate-700">
                                        {{ $movement->created_at?->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-slate-700">
                                        @php
                                            $typeLabels = [
                                                'entry' => 'Entrée',
                                                'sale' => 'Sortie (vente)',
                                                'adjustment' => 'Ajustement',
                                                'loss' => 'Perte',
                                            ];
                                            $type = $movement->movement_type;
                                        @endphp
                                        {{ $typeLabels[$type] ?? ucfirst($type) }}
                                    </td>
                                    <td class="px-3 py-2 text-center font-semibold {{ $movement->movement_type === 'entry' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $movement->movement_type === 'entry' ? '+' : '-' }}{{ $movement->quantity }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-slate-700">
                                        {{ optional($movement->user)->name ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-xs text-slate-500">
                                        Aucun mouvement de stock enregistré pour ce produit.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

