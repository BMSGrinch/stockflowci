@extends('layouts.template')

@section('title', 'Détails du fournisseur')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">
                {{ $supplier->name }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Fiche fournisseur · {{ $supplier->email ?? 'Email non renseigné' }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('suppliers.edit', $supplier) }}"
               class="inline-flex items-center gap-2 rounded-full border border-emerald-300 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 hover:bg-emerald-100 transition">
                Modifier le fournisseur
            </a>
            <a href="{{ route('suppliers.index') }}"
               class="inline-flex items-center rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                Retour à la liste
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid gap-4 lg:grid-cols-3">
        {{-- Fiche fournisseur --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5">
                <h2 class="text-sm font-semibold text-slate-900 mb-4">Informations générales</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Nom</dt>
                        <dd class="text-slate-900">{{ $supplier->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Email</dt>
                        <dd class="text-slate-900">{{ $supplier->email ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Téléphone</dt>
                        <dd class="text-slate-900">{{ $supplier->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">Nombre de produits</dt>
                        <dd class="text-slate-900 font-semibold">{{ $supplier->products->count() }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Produits associés --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-5 overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-slate-900">Produits associés</h2>
                </div>

                <div class="overflow-x-auto -mx-3 sm:mx-0">
                    <table class="min-w-full divide-y divide-slate-200 text-xs sm:text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                    Référence
                                </th>
                                <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                    Nom
                                </th>
                                <th class="px-3 py-2 text-left font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                    Catégorie
                                </th>
                                <th class="px-3 py-2 text-center font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                    Stock
                                </th>
                                <th class="px-3 py-2 text-right font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                    Prix vente
                                </th>
                                <th class="px-3 py-2 text-right font-semibold text-slate-500 uppercase tracking-wide text-[10px] sm:text-xs">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($supplier->products as $product)
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-3 py-2 whitespace-nowrap font-mono text-xs text-slate-800">
                                        {{ $product->reference }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-slate-900 font-medium">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-slate-700">
                                        {{ $product->category ?? '—' }}
                                    </td>
                                    <td class="px-3 py-2 text-center text-slate-900 font-semibold">
                                        {{ $product->quantity }}
                                    </td>
                                    <td class="px-3 py-2 text-right text-slate-900">
                                        {{ number_format($product->selling_price, 0, ',', ' ') }} FCFA
                                    </td>
                                    <td class="px-3 py-2 text-right">
                                        <a href="{{ route('products.show', $product) }}"
                                           class="inline-flex items-center rounded-full border border-slate-300 px-2.5 py-1 text-xs text-slate-700 hover:bg-slate-100">
                                            Voir produit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-4 text-center text-xs text-slate-500">
                                        Aucun produit associé à ce fournisseur pour le moment.
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

