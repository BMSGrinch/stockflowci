@extends('layouts.template')

@section('title', 'Ventes')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Ventes</h1>
            <p class="text-sm text-slate-500 mt-1">
                Gérez les ventes, factures et historiques de transactions.
            </p>
        </div>
        {{-- Filtre par moyen de paiement --}}
        <form method="GET" action="{{ route('sales.index') }}" class="flex items-center gap-2">
            <label for="payment_method" class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                Moyen de paiement
            </label>
            <select id="payment_method" name="payment_method"
                    class="rounded-full border border-slate-300 bg-white px-3 py-1.5 text-xs text-slate-800 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                <option value="">Tous</option>
                <option value="cash" @selected(($paymentFilter ?? null) === 'cash')>Espèces</option>
                <option value="mobile_money" @selected(($paymentFilter ?? null) === 'mobile_money')>Mobile money</option>
                <option value="carte" @selected(($paymentFilter ?? null) === 'carte')>Carte</option>
            </select>
            <button type="submit"
                    class="inline-flex items-center rounded-full bg-slate-900 px-3 py-1.5 text-xs font-medium text-slate-100 hover:bg-slate-800 transition">
                Filtrer
            </button>
        </form>
    </div>
@endsection

@section('content')
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-xs sm:text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Date
                        </th>
                        <th class="px-4 py-3 text-left text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Vendeur
                        </th>
                        <th class="px-4 py-3 text-center text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Nombre d&apos;articles
                        </th>
                        <th class="px-4 py-3 text-right text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Montant total
                        </th>
                        <th class="px-4 py-3 text-center text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Moyen de paiement
                        </th>
                        <th class="px-4 py-3 text-right text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sales as $sale)
                        @php
                            $countItems = $sale->sale_items_count ?? $sale->saleItems->count() ?? 0;

                            $badgeVariant = 'default';
                            $badgeLabel = $sale->payment_method;
                            if ($sale->payment_method === 'cash') {
                                $badgeVariant = 'success';
                                $badgeLabel = 'Espèces';
                            } elseif ($sale->payment_method === 'mobile_money') {
                                $badgeVariant = 'warning';
                                $badgeLabel = 'Mobile money';
                            } elseif ($sale->payment_method === 'carte') {
                                $badgeVariant = 'default';
                                $badgeLabel = 'Carte';
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-3 whitespace-nowrap text-slate-700">
                                {{ $sale->created_at?->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-slate-800">
                                {{ optional($sale->user)->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-center text-slate-900 font-semibold">
                                {{ $countItems }}
                            </td>
                            <td class="px-4 py-3 text-right text-slate-900 font-semibold">
                                {{ number_format($sale->total_amount, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-4 py-3 text-center">
                                <x-badges :variant="$badgeVariant">
                                    {{ $badgeLabel }}
                                </x-badges>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('sales.show', $sale) }}
                                       " class="inline-flex items-center rounded-full border border-slate-300 px-2.5 py-1 text-[11px] text-slate-700 hover:bg-slate-100">
                                        Voir
                                    </a>
                                    <button type="button"
                                            class="inline-flex items-center rounded-full border border-emerald-300 px-2.5 py-1 text-[11px] text-emerald-700 hover:bg-emerald-50">
                                        Exporter
                                    </button>
                                    <button type="button"
                                            class="inline-flex items-center rounded-full border border-slate-400 px-2.5 py-1 text-[11px] text-slate-800 hover:bg-slate-100">
                                        Imprimer
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">
                                Aucune vente enregistrée pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sales instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="border-t border-slate-200 bg-slate-50 px-4 py-3">
                <div class="flex items-center justify-between text-xs text-slate-500">
                    <div>
                        Affichage de
                        <span class="font-semibold">{{ $sales->firstItem() ?? 0 }}</span>
                        à
                        <span class="font-semibold">{{ $sales->lastItem() ?? 0 }}</span>
                        sur
                        <span class="font-semibold">{{ $sales->total() }}</span>
                        ventes
                    </div>
                    <div>
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

