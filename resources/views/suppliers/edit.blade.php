@extends('layouts.template')

@section('title', 'Modifier le fournisseur')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Modifier le fournisseur</h1>
            <p class="text-sm text-slate-500 mt-1">
                Mettez à jour les informations de ce partenaire.
            </p>
        </div>
    </div>
@endsection

@section('content')
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6 max-w-2xl">
        <form id="supplier-form" method="POST" action="{{ route('suppliers.update', $supplier) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Nom --}}
                <div class="md:col-span-2 space-y-1.5">
                    <label for="name" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Nom
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}"
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                </div>

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $supplier->email) }}"
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                </div>

                {{-- Téléphone --}}
                <div class="space-y-1.5">
                    <label for="phone" class="block text-xs font-medium uppercase tracking-wide text-slate-600">
                        Téléphone
                    </label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}"
                           class="block w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 outline-none">
                </div>
            </div>

            {{-- Boutons bas de page --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('suppliers.index') }}"
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

