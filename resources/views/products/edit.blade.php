@extends('layouts.template')

@section('title', 'Modifier le produit')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Modifier le produit</h1>
            <p class="text-sm text-slate-500 mt-1">
                Mettez à jour les informations de ce produit.
            </p>
        </div>
        <div>
            <button form="product-form" type="submit"
                    class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-medium text-slate-950 shadow-[0_0_0_0_rgba(16,185,129,0.7)] hover:shadow-[0_0_20px_2px_rgba(16,185,129,0.6)] hover:bg-emerald-400 transition">
                <span>Enregistrer +</span>
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6 max-w-3xl">
        <form id="product-form" method="POST" action="{{ route('products.update', $product) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Nom --}}
                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Nom
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                </div>

                {{-- Référence --}}
                <div class="space-y-1.5">
                    <label for="reference" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Référence
                    </label>
                    <input type="text" id="reference" name="reference" value="{{ old('reference', $product->reference) }}"
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                </div>

                {{-- Catégorie --}}
                <div class="space-y-1.5">
                    <label for="category" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Catégorie
                    </label>
                    <input type="text" id="category" name="category" value="{{ old('category', $product->category) }}"
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                </div>

                {{-- Fournisseur --}}
                <div class="space-y-1.5">
                    <label for="supplier_id" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Fournisseur
                    </label>
                    <select id="supplier_id" name="supplier_id"
                            class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                        <option value="">Aucun fournisseur</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Prix achat --}}
                <div class="space-y-1.5">
                    <label for="purchase_price" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Prix d&apos;achat
                    </label>
                    <div class="relative">
                        <input type="number" step="0.01" min="0" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}"
                               class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 pr-12 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-[11px] text-slate-500">
                            FCFA
                        </span>
                    </div>
                </div>

                {{-- Prix vente --}}
                <div class="space-y-1.5">
                    <label for="selling_price" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Prix de vente
                    </label>
                    <div class="relative">
                        <input type="number" step="0.01" min="0" id="selling_price" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}"
                               class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 pr-12 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-[11px] text-slate-500">
                            FCFA
                        </span>
                    </div>
                </div>

                {{-- Quantité --}}
                <div class="space-y-1.5">
                    <label for="quantity" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Quantité
                    </label>
                    <input type="number" min="0" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}"
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                </div>

                {{-- Seuil d'alerte --}}
                <div class="space-y-1.5">
                    <label for="alert_threshold" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Seuil d&apos;alerte
                    </label>
                    <input type="number" min="0" id="alert_threshold" name="alert_threshold" value="{{ old('alert_threshold', $product->alert_threshold) }}"
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                </div>
            </div>

            {{-- Statut (toggle actif/inactif) --}}
            <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50/60 px-4 py-3">
                <div class="space-y-0.5">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-600">
                        Statut
                    </p>
                    <p class="text-xs text-slate-500">
                        Activez ou désactivez ce produit pour la vente.
                    </p>
                </div>
                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active)) class="peer sr-only">
                    <span class="h-5 w-9 rounded-full bg-slate-300 peer-checked:bg-emerald-500 transition-colors relative">
                        <span class="absolute top-[2px] left-[2px] h-4 w-4 rounded-full bg-white shadow-sm peer-checked:translate-x-4 transition-transform"></span>
                    </span>
                    <span class="text-xs text-slate-600 peer-checked:text-emerald-600">
                        Actif
                    </span>
                </label>
            </div>

            {{-- Boutons bas de page --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-rose-50 hover:border-rose-300 hover:text-rose-700 transition">
                    Annuler
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-medium text-slate-950 shadow-[0_0_0_0_rgba(16,185,129,0.7)] hover:shadow-[0_0_20px_2px_rgba(16,185,129,0.6)] hover:bg-emerald-400 transition">
                    Enregistrer +
                </button>
            </div>
        </form>
    </div>
@endsection

