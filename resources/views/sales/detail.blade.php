@extends('layouts.template')

@section('title', 'Détail de la vente')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">
                Vente #{{ $sale->id }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Effectuée le {{ $sale->created_at->format('d/m/Y à H:i') }} ·
                par {{ $sale->user->name ?? 'Vendeur inconnu' }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                @if($sale->payment_method === 'cash')
                    bg-amber-50 text-amber-700 border border-amber-200
                @elseif($sale->payment_method === 'mobile_money')
                    bg-emerald-50 text-emerald-700 border border-emerald-200
                @else
                    bg-indigo-50 text-indigo-700 border border-indigo-200
                @endif
            ">
                {{ strtoupper(str_replace('_', ' ', $sale->payment_method)) }}
            </span>
            <a href="{{ route('sales.index') }}"
               class="inline-flex items-center rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                Retour aux ventes
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        {{-- Informations générales de la vente --}}
        <div class="grid gap-4 lg:grid-cols-3">
            <div class="lg:col-span-1">
                <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4">Informations générales</h2>
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Numéro de vente</dt>
                            <dd class="text-slate-900 font-mono text-sm">#{{ $sale->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Date</dt>
                            <dd class="text-slate-900">
                                {{ $sale->created_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Vendeur</dt>
                            <dd class="text-slate-900">
                                {{ $sale->user->name ?? 'Non renseigné' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Moyen de paiement</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                    @if($sale->payment_method === 'cash')
                                        bg-amber-50 text-amber-700 border border-amber-200
                                    @elseif($sale->payment_method === 'mobile_money')
                                        bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @else
                                        bg-indigo-50 text-indigo-700 border border-indigo-200
                                    @endif
                                ">
                                    {{ strtoupper(str_replace('_', ' ', $sale->payment_method)) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total</dt>
                            <dd class="text-lg font-semibold text-emerald-700">
                                {{ number_format($sale->total_amount, 0, ',', ' ') }} FCFA
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Tableau des articles vendus --}}
            <div class="lg:col-span-2">
                <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5 overflow-hidden">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-semibold text-slate-900">Articles vendus</h2>
                    </div>

                    <div class="overflow-x-auto -mx-3 sm:mx-0">
                        <table class="min-w-full divide-y divide-slate-200 text-xs sm:text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                        Produit
                                    </th>
                                    <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                        Référence
                                    </th>
                                    <th class="px-3 py-2 text-center font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                        Quantité
                                    </th>
                                    <th class="px-3 py-2 text-right font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                        Prix unitaire
                                    </th>
                                    <th class="px-3 py-2 text-right font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                        Sous-total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($sale->saleItems as $item)
                                    <tr class="hover:bg-slate-50/60">
                                        <td class="px-3 py-2 whitespace-nowrap text-slate-900 font-medium">
                                            {{ $item->product->name ?? 'Produit supprimé' }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap font-mono text-xs text-slate-800">
                                            {{ $item->product->reference ?? '—' }}
                                        </td>
                                        <td class="px-3 py-2 text-center text-slate-900 font-semibold">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-3 py-2 text-right text-slate-900">
                                            {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td class="px-3 py-2 text-right text-slate-900 font-semibold">
                                            {{ number_format($item->quantity * $item->unit_price, 0, ',', ' ') }} FCFA
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 py-4 text-center text-xs text-slate-500">
                                            Aucun article enregistré pour cette vente.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total général en bas --}}
        <div class="rounded-2xl bg-white shadow-sm border border-emerald-200 px-5 py-4 flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total général</p>
                <p class="text-sm text-slate-500">
                    Montant total de la vente #{{ $sale->id }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-emerald-700">
                    {{ number_format($sale->total_amount, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>
    </div>
@endsection

