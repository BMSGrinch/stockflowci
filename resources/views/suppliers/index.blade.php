@extends('layouts.template')

@section('title', 'Fournisseurs')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Fournisseurs</h1>
            <p class="text-sm text-slate-500 mt-1">
                Centralisez vos partenaires et informations de contact.
            </p>
        </div>
        <div>
            <a href="{{ route('suppliers.create') }}"
               class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-medium text-slate-950 shadow-sm hover:bg-emerald-400 transition">
                <span class="text-lg leading-none">+</span>
                <span>Ajouter un fournisseur</span>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nom</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Téléphone</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Produits associés</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($suppliers as $supplier)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-3 font-medium text-slate-900">
                                {{ $supplier->name }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $supplier->email ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $supplier->phone ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-center text-slate-900 font-semibold">
                                {{ $supplier->products_count ?? 0 }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2 text-xs">
                                    <a href="{{ route('suppliers.show', $supplier) }}"
                                       class="inline-flex items-center rounded-full border border-slate-300 px-2.5 py-1 text-slate-700 hover:bg-slate-100">
                                        Voir
                                    </a>
                                    <a href="{{ route('suppliers.edit', $supplier) }}"
                                       class="inline-flex items-center rounded-full border border-emerald-300 px-2.5 py-1 text-emerald-700 hover:bg-emerald-50">
                                        Modifier
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST"
                                          onsubmit="return confirm('Supprimer ce fournisseur ?');">
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
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">
                                Aucun fournisseur enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suppliers instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="border-t border-slate-200 bg-slate-50 px-4 py-3">
                <div class="flex items-center justify-between text-xs text-slate-500">
                    <div>
                        Affichage de
                        <span class="font-semibold">{{ $suppliers->firstItem() ?? 0 }}</span>
                        à
                        <span class="font-semibold">{{ $suppliers->lastItem() ?? 0 }}</span>
                        sur
                        <span class="font-semibold">{{ $suppliers->total() }}</span>
                        fournisseurs
                    </div>
                    <div>
                        {{ $suppliers->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

