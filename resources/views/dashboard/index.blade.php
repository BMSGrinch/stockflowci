@extends('layouts.template')

@section('title', 'Dashboard')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Tableau de bord</h1>
            <p class="text-sm text-slate-500 mt-1">
                Vue d'ensemble de votre stock et de vos ventes.
            </p>
        </div>
    </div>
@endsection

@section('content')
    {{-- Cartes de statistiques principales --}}
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4 mb-8">
        {{-- Produits actifs --}}
        <div class="rounded-2xl bg-white shadow-sm border border-emerald-200 p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium text-emerald-700 uppercase tracking-wide">Produits actifs</p>
            </div>
            <p class="mt-3 text-3xl font-bold text-emerald-700">
                {{ number_format($totalProduitsActif ?? 0, 0, ',', ' ') }}
            </p>
        </div>

        {{-- Produits en alerte --}}
        <div class="rounded-2xl bg-white shadow-sm border border-amber-200 p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium text-amber-700 uppercase tracking-wide">Produits en alerte</p>
            </div>
            <p class="mt-3 text-3xl font-bold text-amber-700">
                {{ number_format($produitsAlerte ?? 0, 0, ',', ' ') }}
            </p>
        </div>

        {{-- Ventes du jour --}}
        <div class="rounded-2xl bg-white shadow-sm border border-emerald-200 p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium text-emerald-700 uppercase tracking-wide">Ventes du jour</p>
            </div>
            <p class="mt-3 text-3xl font-bold text-emerald-700">
                {{ number_format($ventesJour ?? 0, 0, ',', ' ') }}
            </p>
        </div>

        {{-- CA du mois --}}
        <div class="rounded-2xl bg-white shadow-sm border border-emerald-200 p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium text-emerald-700 uppercase tracking-wide">CA du mois</p>
            </div>
            <p class="mt-3 text-3xl font-bold text-emerald-700">
                {{ number_format($caMois ?? 0, 0, ',', ' ') }} FCFA
            </p>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="grid gap-6 lg:grid-cols-2 mb-8">
        {{-- Ventes des 7 derniers jours --}}
        <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">Ventes des 7 derniers jours</h2>
            <div class="h-64">
                <canvas id="ventes-7-jours-chart"></canvas>
            </div>
        </div>

        {{-- Ventes par moyen de paiement --}}
        <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">Répartition des ventes par moyen de paiement</h2>
            <div class="h-64">
                <canvas id="ventes-paiement-chart"></canvas>
            </div>
        </div>
    </div>

    {{-- Tableaux --}}
    <div class="grid gap-6 lg:grid-cols-2">
        {{-- 5 dernières ventes --}}
        <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5 overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-900">5 dernières ventes</h2>
            </div>

            <div class="overflow-x-auto -mx-3 sm:mx-0">
                <table class="min-w-full divide-y divide-slate-200 text-xs sm:text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                Date
                            </th>
                            <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                Vendeur
                            </th>
                            <th class="px-3 py-2 text-right font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                Total
                            </th>
                            <th class="px-3 py-2 text-right font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                Paiement
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($dernieresVentes ?? [] as $vente)
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-3 py-2 whitespace-nowrap text-slate-900">
                                    {{ $vente->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-slate-700">
                                    {{ $vente->user->name ?? '—' }}
                                </td>
                                <td class="px-3 py-2 text-right text-slate-900 font-semibold">
                                    {{ number_format($vente->total_amount, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-3 py-2 text-right text-slate-700">
                                    {{ strtoupper(str_replace('_', ' ', $vente->payment_method)) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-xs text-slate-500">
                                    Aucune vente récente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 5 derniers mouvements de stock --}}
        <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5 overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-900">5 derniers mouvements de stock</h2>
            </div>

            <div class="overflow-x-auto -mx-3 sm:mx-0">
                <table class="min-w-full divide-y divide-slate-200 text-xs sm:text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                Date
                            </th>
                            <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                Produit
                            </th>
                            <th class="px-3 py-2 text-center font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                Mouvement
                            </th>
                            <th class="px-3 py-2 text-center font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                Quantité
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($derniersMovements ?? [] as $mouvement)
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-3 py-2 whitespace-nowrap text-slate-900">
                                    {{ $mouvement->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-slate-700">
                                    {{ $mouvement->product->name ?? '—' }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-medium
                                        @if($mouvement->movement_type === 'entry')
                                            bg-emerald-50 text-emerald-700 border border-emerald-200
                                        @else
                                            bg-rose-50 text-rose-700 border border-rose-200
                                        @endif
                                    ">
                                        {{ $mouvement->movement_type === 'entry' ? 'Entrée' : 'Sortie' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center text-slate-900 font-semibold">
                                    {{ $mouvement->quantity }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-xs text-slate-500">
                                    Aucun mouvement récent.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Scripts Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ventesParJour = @json($ventesParJour ?? []); 
            const ventesParPaiement = @json($ventesParPaiement ?? []);

            // Bar chart - ventes des 7 derniers jours
            const ctxBar = document.getElementById('ventes-7-jours-chart')?.getContext('2d');
            if (ctxBar && Array.isArray(ventesParJour) && ventesParJour.length) {
                const labels = ventesParJour.map(v => v.date);
                const data = ventesParJour.map(v => v.total);

                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Total ventes (FCFA)',
                            data,
                            backgroundColor: 'rgba(16, 185, 129, 0.5)',
                            borderColor: 'rgba(5, 150, 105, 1)',
                            borderWidth: 1.5,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: value => value.toLocaleString('fr-FR')
                                }
                            }
                        }
                    }
                });
            }

            // Pie chart - ventes par moyen de paiement
            const ctxPie = document.getElementById('ventes-paiement-chart')?.getContext('2d');
            if (ctxPie && Array.isArray(ventesParPaiement) && ventesParPaiement.length) {
                const labels = ventesParPaiement.map(v => v.payment_method);
                const data = ventesParPaiement.map(v => v.total);

                new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels,
                        datasets: [{
                            data,
                            backgroundColor: [
                                'rgba(16, 185, 129, 0.7)',
                                'rgba(59, 130, 246, 0.7)',
                                'rgba(234, 179, 8, 0.7)',
                                'rgba(239, 68, 68, 0.7)'
                            ],
                            borderColor: 'white',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
            
        });
    </script>
@endsection
