@extends('layouts.template')

@section('title', 'Nouveau mouvement de stock')

@section('page-header')
    <div>
        <h1 class="text-xl font-semibold text-slate-900">Nouveau mouvement de stock</h1>
        <p class="text-sm text-slate-500 mt-1">
            Enregistrez une entrée, un ajustement ou une perte de stock.
        </p>
    </div>
@endsection

@section('content')
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('stocks.index') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

            <div class="space-y-4">
                {{-- Produit --}}
                <div class="space-y-1.5">
                    <label for="product_id" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Produit
                    </label>
                    <select id="product_id" name="product_id" required
                            class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none @error('product_id') border-rose-400 @enderror">
                        <option value="">Choisir un produit</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                {{ $product->name }}{{ $product->reference ? ' (' . $product->reference . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Type de mouvement --}}
                <div class="space-y-1.5">
                    <label for="movement_type" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Type de mouvement
                    </label>
                    <select id="movement_type" name="movement_type" required
                            class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none @error('movement_type') border-rose-400 @enderror">
                        <option value="">Choisir un type</option>
                        <option value="entry" @selected(old('movement_type') === 'entry')>Entrée</option>
                        <option value="adjustment" @selected(old('movement_type') === 'adjustment')>Ajustement</option>
                        <option value="loss" @selected(old('movement_type') === 'loss')>Perte</option>
                    </select>
                    @error('movement_type')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quantité --}}
                <div class="space-y-1.5">
                    <label for="quantity" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Quantité
                    </label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" required
                           step="1"
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none @error('quantity') border-rose-400 @enderror"
                           placeholder="Ex. 10">
                    @error('quantity')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Note --}}
                <div class="space-y-1.5">
                    <label for="note" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Note <span class="text-slate-400 font-normal">(optionnel)</span>
                    </label>
                    <input type="text" id="note" name="note" value="{{ old('note') }}" maxlength="255"
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none @error('note') border-rose-400 @enderror"
                           placeholder="Commentaire ou référence">
                    @error('note')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Boutons --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('stocks.index') }}"
                   class="inline-flex items-center rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:border-slate-400 transition">
                    Annuler
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-medium text-slate-950 shadow-sm hover:bg-emerald-400 transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
@endsection
