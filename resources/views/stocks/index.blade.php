@extends('layouts.template')

@section('title', 'Stock')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Mouvements de stock</h1>
            <p class="text-sm text-slate-500 mt-1">
                Suivez les entrées, ventes, ajustements et pertes de stock.
            </p>
        </div>
        <div>
            <a href="{{ route('stocks.create') }}"
               class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-medium text-slate-950 shadow-sm hover:bg-emerald-400 transition">
                <span class="text-lg leading-none">+</span>
                <span>Nouveau mouvement</span>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 overflow-hidden">
        {{-- Barre de filtres --}}
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
            <form method="GET" action="{{ route('stocks.index') }}" class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <label for="movement_type" class="text-xs font-medium text-slate-600 uppercase tracking-wide">
                        Type de mouvement
                    </label>
                    <select id="movement_type"
                            name="movement_type"
                            onchange="this.form.submit()"
                            class="rounded-full border border-slate-300 bg-white px-3 py-1.5 text-xs text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Tous</option>
                        <option value="entry" @selected(request('movement_type') === 'entry')>Entrées</option>
                        <option value="sale" @selected(request('movement_type') === 'sale')>Ventes</option>
                        <option value="adjustment" @selected(request('movement_type') === 'adjustment')>Ajustements</option>
                        <option value="loss" @selected(request('movement_type') === 'loss')>Pertes</option>
                    </select>
                </div>

                @if(request()->filled('movement_type'))
                    <a href="{{ route('stocks.index') }}"
                       class="inline-flex items-center text-xs text-slate-500 hover:text-slate-700">
                        Effacer le filtre
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Date
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Produit
                        </th>
                        <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Type de mouvement
                        </th>
                        <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Quantité
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Utilisateur
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Note
                        </th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stocks as $stock)
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
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-3 whitespace-nowrap text-slate-700">
                                {{ optional($stock->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-slate-900 font-medium">
                                {{ optional($stock->product)->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <x-badges :variant="$typeVariant">
                                    {{ $typeLabel }}
                                </x-badges>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="font-semibold {{ $quantityColor }}">
                                    {{ $sign }}{{ $absoluteQuantity }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-700">
                                {{ optional($stock->user)->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600 max-w-xs">
                                {{ $stock->note ?: '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2 text-xs">
                                    <a href="{{ route('stocks.show', $stock) }}" 
                                       class="inline-flex items-center rounded-full border border-slate-300 px-2.5 py-1 text-slate-700 hover:bg-slate-100">
                                        Voir
                                    </a>
                                    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">
                                Aucun mouvement de stock enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($stocks instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="border-t border-slate-200 bg-slate-50 px-4 py-3">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
                    <div>
                        Affichage de
                        <span class="font-semibold">{{ $stocks->firstItem() ?? 0 }}</span>
                        à
                        <span class="font-semibold">{{ $stocks->lastItem() ?? 0 }}</span>
                        sur
                        <span class="font-semibold">{{ $stocks->total() }}</span>
                        mouvements
                        @if(request()->filled('movement_type'))
                            filtrés par
                            <span class="font-semibold">
                                @switch(request('movement_type'))
                                    @case('entry') entrées @break
                                    @case('sale') ventes @break
                                    @case('adjustment') ajustements @break
                                    @case('loss') pertes @break
                                @endswitch
                            </span>
                        @endif
                    </div>
                    <div class="sm:text-right">
                        {{ $stocks->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

