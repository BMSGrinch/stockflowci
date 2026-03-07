@extends('layouts.template')

@section('title', 'Achats / Produits')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Produits / Achats</h1>
            <p class="text-sm text-slate-500 mt-1">
                Gérez le catalogue produits et les commandes d&apos;achat.
            </p>
        </div>
        <div>
            <a href="{{ route('products.create') }}"
               class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-medium text-slate-950 shadow-sm hover:bg-emerald-400 transition">
                <span class="text-lg leading-none">+</span>
                <span>Ajouter un produit</span>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Référence</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nom</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Catégorie</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Fournisseur</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Prix achat</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Prix vente</th>
                        <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Stock</th>
                        <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Statut</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
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
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-3 font-mono text-xs text-slate-700">{{ $product->reference }}</td>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $product->category ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ optional($product->supplier)->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-right text-slate-700">
                                {{ number_format($product->purchase_price, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-4 py-3 text-right text-slate-700">
                                {{ number_format($product->selling_price, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-4 py-3 text-center text-slate-900 font-semibold">
                                {{ $quantity }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <x-badges :variant="$statusVariant">
                                    {{ $statusLabel }}
                                </x-badges>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2 text-xs">
                                    <a href="{{ route('products.show', $product) }}" 
                                       class="inline-flex items-center rounded-full border border-slate-300 px-2.5 py-1 text-slate-700 hover:bg-slate-100">
                                        Voir
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}"
                                       class="inline-flex items-center rounded-full border border-emerald-300 px-2.5 py-1 text-emerald-700 hover:bg-emerald-50">
                                        Modifier
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('Supprimer ce produit ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center rounded-full border border-rose-300 px-2.5 py-1 text-rose-700 hover:bg-rose-50">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-sm text-slate-500">
                                Aucun produit enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="border-t border-slate-200 bg-slate-50 px-4 py-3">
                <div class="flex items-center justify-between text-xs text-slate-500">
                    <div>
                        Affichage de
                        <span class="font-semibold">{{ $products->firstItem() ?? 0 }}</span>
                        à
                        <span class="font-semibold">{{ $products->lastItem() ?? 0 }}</span>
                        sur
                        <span class="font-semibold">{{ $products->total() }}</span>
                        produits
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

