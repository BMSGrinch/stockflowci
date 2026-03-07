<aside class=" bg-slate-950 text-slate-100 flex flex-col border-r border-slate-800">
    {{-- Logo / Brand --}}
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-800">
        <div class="h-9 w-9 rounded-xl bg-emerald-500 flex items-center justify-center shadow-lg shadow-emerald-500/40">
            <span class="text-xl font-bold">SF</span>
        </div>
        <div class="flex flex-col">
            <span class="text-sm font-semibold tracking-tight">StockFlow CI</span>
            <span class="text-[11px] text-slate-400">Gestion d&apos;inventaire</span>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6 text-sm h-full">
        {{-- Section Principale --}}
        <div class="space-y-1">
            <p class="px-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500 mb-2">
                Principale
            </p>
           
            <nav class="space-y-2">
                {{-- Dashboard (lien direct) --}}
                <a href="{{ route('dashboard') }}"
                   class="ml-8 flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-slate-200 hover:bg-slate-800/80 hover:text-white transition
                   {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-white' : '' }}">
                    <span class="h-1 w-1 rounded-full bg-slate-500"></span>
                    <span class="text-[13px]">Dashboard</span>
                </a>

               {{-- Section Stock --}}
                <div class="space-y-1">
                    <div class="flex items-center gap-3 px-2.5 py-1 text-slate-400 uppercase text-[10px] tracking-[0.2em]">
                        <p class="px-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500 mb-2">Stock</p>
                    </div>
                    <a href="{{ route('stocks.index') }}"
                       class="ml-8 flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-slate-200 hover:bg-slate-800/80 hover:text-white transition
                       {{ request()->routeIs('stock-movements.*') ? 'bg-slate-800 text-white' : '' }}">
                        <span class="h-1 w-1 rounded-full bg-slate-500"></span>
                        <span class="text-[13px]">Mouvements de stock</span>
                    </a>

                    {{-- Sous-section Produits --}}
                    <div class="group ml-8">
                        <button class="flex w-full items-center gap-2 px-2.5 py-1.5 rounded-lg text-slate-200 hover:bg-slate-800/80 hover:text-white transition cursor-pointer">
                            <span class="h-1 w-1 rounded-full bg-slate-500"></span>
                            <span class="text-[13px]">Produit</span>
                            <svg class="w-3 h-3 ml-auto mr-2 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="hidden flex-col pl-6 mt-1 space-y-1 group-hover:flex">
                            <a href="{{ route('products.index') }}" class="block px-2 py-1.5 text-xs text-slate-400 hover:text-slate-200 transition {{ request()->routeIs('products.index') ? 'text-white' : '' }}">Liste des produits</a>
                            <a href="{{ route('products.create') }}" class="block px-2 py-1.5 text-xs text-slate-400 hover:text-slate-200 transition {{ request()->routeIs('products.create') ? 'text-white' : '' }}">Ajouter produit</a>
                        </div>
                    </div>
                </div>

                {{-- Section Ventes --}}
                <div class="space-y-1">
                    <div class="flex items-center gap-3 px-2.5 py-1 text-slate-400 uppercase text-[10px] tracking-[0.2em]">
                        <p class="px-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500 mb-2">Ventes</p>
                    </div>
                    <a href="{{ route('sales.index') }}"
                       class="ml-8 flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-slate-200 hover:bg-slate-800/80 hover:text-white transition
                       {{ request()->routeIs('sales.index') ? 'bg-slate-800 text-white' : '' }}">
                        <span class="h-1 w-1 rounded-full bg-slate-500"></span>
                        <span class="text-[13px]">Liste des ventes</span>
                    </a>
                    <a href="{{ route('sales.create') }}"
                       class="ml-8 flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-slate-200 hover:bg-slate-800/80 hover:text-white transition
                       {{ request()->routeIs('sales.create') ? 'bg-slate-800 text-white' : '' }}">
                        <span class="h-1 w-1 rounded-full bg-slate-500"></span>
                        <span class="text-[13px]">Nouvelle vente</span>
                    </a>
                </div>

                {{-- Section Achats --}}
                <div class="space-y-1">
                    <div class="flex items-center gap-3 px-2.5 py-1 text-slate-400 uppercase text-[10px] tracking-[0.2em]">
                        <p class="px-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500 mb-2">Achats</p>
                    </div>
                    {{-- Sous-section Fournisseurs --}}
                    <div class="group ml-8">
                        <button class="flex w-full items-center gap-2 px-2.5 py-1.5 rounded-lg text-slate-200 hover:bg-slate-800/80 hover:text-white transition cursor-pointer">
                            <span class="h-1 w-1 rounded-full bg-slate-500"></span>
                            <span class="text-[13px]">Fournisseurs</span>
                            <svg class="w-3 h-3 ml-auto mr-2 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="hidden flex-col pl-6 mt-1 space-y-1 group-hover:flex">
                            <a href="{{ route('suppliers.index') }}" class="block px-2 py-1.5 text-xs text-slate-400 hover:text-slate-200 transition {{ request()->routeIs('suppliers.index') ? 'text-white' : '' }}">Liste des fournisseurs</a>
                            <a href="{{ route('suppliers.create') }}" class="block px-2 py-1.5 text-xs text-slate-400 hover:text-slate-200 transition {{ request()->routeIs('suppliers.create') ? 'text-white' : '' }}">Ajout fournisseurs</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        {{-- Section Autres (thème, infos, etc.) --}}
        <div>
            <p class="px-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500 mb-2">
                Autres
            </p>
            <div class="space-y-1">
                <button type="button"
                        class="w-full flex items-center justify-between gap-3 px-2.5 py-2 rounded-lg text-slate-200 hover:bg-slate-800/80 hover:text-white transition">
                    <span class="flex items-center gap-3">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-slate-900 text-[13px]">🎨</span>
                        <span>Thème visuel</span>
                    </span>
                    <span class="text-[11px] text-slate-400">Bientôt</span>
                </button>

                <div class="flex items-center justify-between gap-3 px-2.5 py-2 rounded-lg text-slate-300 bg-slate-900/40 border border-slate-800">
                    <div class="flex flex-col">
                        <span class="text-xs font-medium">StockFlow CI</span>
                        <span class="text-[11px] text-slate-500">Version 0.1.0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section utilisateur  --}}
    <div class="px-3 py-3 border-t border-slate-800">
        <div class="flex items-center gap-3 rounded-xl bg-slate-900/70 px-3 py-2">
            <div class="h-8 w-8 rounded-full bg-emerald-500/80 flex items-center justify-center text-xs font-semibold text-slate-950">
                @switch(auth()->user()->role)
                    @case('admin')
                        AD
                        @break
                    @case('manager')
                        MG
                        @break
                    @case('seller')
                        SL
                        @break
                    @default
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                @endswitch
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-[11px] text-slate-400 truncate">
                    {{ auth()->user()->email }}
                </p>
            </div>

            {{-- Partie déconnexion de l'utilisateur --}}
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-slate-800 hover:bg-emerald-500 hover:text-slate-950 transition h-8 w-8 text-[11px]"
                        title="Déconnexion">
                    ⇨
                </button>
            </form>
        </div>
    </div>
</aside>

