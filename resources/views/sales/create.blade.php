@extends('layouts.template')

@section('title', 'Nouvelle vente')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Interface de caisse</h1>
            <p class="text-sm text-slate-500 mt-1">
                Sélectionnez les produits et validez la vente en quelques clics.
            </p>
        </div>
    </div>
@endsection

@section('content')
    <form id="sale-form" method="POST" action="{{ route('sales.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        @csrf

        {{-- Colonne gauche : produits --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-slate-900">Produits disponibles</h2>
                <p class="text-xs text-slate-500">
                    Cliquez sur un produit pour l&apos;ajouter au panier.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 max-h-[520px] overflow-y-auto pr-1">
                @forelse($products as $product)
                            <button type="button"
                                class="group relative flex flex-col rounded-2xl border border-slate-200 bg-white px-3 py-3 text-left shadow-sm hover:border-emerald-400 hover:shadow-md transition"
                                data-product="{{ json_encode([
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'reference' => $product->reference,
                                    'price' => $product->selling_price,
                                    'stock' => $product->quantity,
                                ]) }}">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <p class="text-xs font-medium text-slate-900 truncate">
                                            {{ $product->name }}
                                        </p>
                                        <p class="mt-0.5 text-[11px] font-mono text-slate-500 truncate">
                                            {{ $product->reference }}
                                        </p>
                                    </div>
                                    <span class="rounded-full bg-slate-900 text-[11px] text-slate-50 px-2 py-0.5">
                                        {{ number_format($product->selling_price, 0, ',', ' ') }} FCFA
                                    </span>
                                </div>

                                <div class="mt-3 flex items-center justify-between text-[11px] text-slate-500">
                                    <span>
                                        Stock : <span class="font-semibold text-slate-800">{{ $product->quantity }}</span>
                                    </span>
                                    <span
                                        class="rounded-full border border-slate-200 px-2 py-0.5 group-hover:border-emerald-400 group-hover:text-emerald-600">
                                        Ajouter
                                    </span>
                                </div>
                            </button>
                @empty
                    <p class="text-sm text-slate-500">
                        Aucun produit disponible à la vente pour le moment.
                    </p>
                @endforelse
            </div>
        </div>

        {{-- Colonne droite : panier --}}
        <div class="space-y-4">
            <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-4 flex flex-col h-full">
                <h2 class="text-sm font-semibold text-slate-900 mb-3">Panier</h2>

                <div class="flex-1 overflow-y-auto -mx-2">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="text-[10px] text-slate-500 uppercase tracking-wide">
                                <th class="px-2 py-1 text-left">Produit</th>
                                <th class="px-2 py-1 text-center">Qté</th>
                                <th class="px-2 py-1 text-right">PU</th>
                                <th class="px-2 py-1 text-right">Sous-total</th>
                                <th class="px-2 py-1 text-right"></th>
                            </tr>
                        </thead>
                        <tbody id="cart-body" class="align-top text-[11px] text-slate-800">
                            <tr id="cart-empty-row">
                                <td colspan="5" class="px-2 py-4 text-center text-xs text-slate-400">
                                    Aucun article pour le moment. Ajoutez des produits à gauche.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Totaux & paiement --}}
                <div class="mt-4 border-t border-slate-200 pt-3 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-600">Total HT</span>
                        <span id="cart-total" class="text-lg font-semibold text-slate-900">
                            0 FCFA
                        </span>
                    </div>

                    {{-- Moyen de paiement --}}
                    <div class="space-y-1.5">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-600">
                            Moyen de paiement
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $methods = [
                                    'cash' => 'Espèces',
                                    'mobile_money' => 'Mobile money',
                                    'carte' => 'Carte',
                                ];
                            @endphp
                            @foreach($methods as $value => $label)
                                <label
                                    class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-xs cursor-pointer hover:border-emerald-400 hover:bg-emerald-50 transition">
                                    <input type="radio" name="payment_method" value="{{ $value }}" class="peer sr-only"
                                        @checked(old('payment_method', 'cash') === $value)>
                                    <span
                                        class="h-3 w-3 rounded-full border border-slate-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 transition"></span>
                                    <span class="text-slate-700 peer-checked:text-emerald-700">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Champs cachés / total --}}
                    <input type="hidden" name="total_amount" id="total_amount" value="0">

                    {{-- Bouton Valider --}}
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-slate-950 shadow-[0_0_0_0_rgba(16,185,129,0.7)] hover:shadow-[0_0_20px_2px_rgba(16,185,129,0.6)] hover:bg-emerald-400 transition disabled:opacity-60 disabled:cursor-not-allowed"
                            id="submit-button">
                            Valider la vente
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Template de ligne panier --}}
    <template id="cart-row-template">
        <tr class="border-t border-slate-100">
            <td class="px-2 py-2">
                <div class="flex flex-col">
                    <span class="font-medium"></span>
                    <span class="font-mono text-[10px] text-slate-400"></span>
                </div>
                <input type="hidden" class="cart-product-id-input" name="items[INDEX][product_id]" value="">
            </td>
            <td class="px-2 py-2 text-center">
                <input type="number" min="1" value="1"
                    class="cart-qty-input w-14 rounded-lg border border-slate-200 bg-slate-50 px-1.5 py-1 text-[11px] text-center outline-none focus:border-emerald-400 focus:ring-1 focus:ring-emerald-100">
                <input type="hidden" class="cart-max-stock" value="">
                <input type="hidden" class="cart-qty-hidden" name="items[INDEX][quantity]" value="1">
            </td>
            <td class="px-2 py-2 text-right text-[11px]">
                <span class="cart-price"></span>
                <input type="hidden" class="cart-price-input" name="items[INDEX][unit_price]" value="">
            </td>
            <td class="px-2 py-2 text-right text-[11px] font-semibold">
                <span class="cart-line-total"></span>
            </td>
            <td class="px-2 py-2 text-right">
                <button type="button"
                    class="cart-remove-btn inline-flex items-center rounded-full border border-rose-300 px-2 py-0.5 text-[10px] text-rose-700 hover:bg-rose-50">
                    ✕
                </button>
            </td>
        </tr>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productButtons = document.querySelectorAll('[data-product]');
            const cartBody = document.getElementById('cart-body');
            const emptyRow = document.getElementById('cart-empty-row');
            const rowTemplate = document.getElementById('cart-row-template');
            const totalDisplay = document.getElementById('cart-total');
            const totalInput = document.getElementById('total_amount');
            const submitButton = document.getElementById('submit-button');

            let cartIndex = 0;
            const cart = new Map(); // key: productId, value: { rowElement, qty, maxStock, price }

            function formatCurrency(value) {
                return new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'XOF',
                    maximumFractionDigits: 0
                }).format(value);
            }

            function recalcTotal() {
                let total = 0;
                cart.forEach((item) => {
                    total += item.qty * item.price;
                });
                totalDisplay.textContent = total > 0 ? formatCurrency(total) : '0 FCFA';
                totalInput.value = total;
                submitButton.disabled = cart.size === 0;
            }

            function ensureNotEmpty() {
                if (cart.size === 0) {
                    if (!emptyRow) return;
                    emptyRow.classList.remove('hidden');
                } else if (emptyRow) {
                    emptyRow.classList.add('hidden');
                }
            }

            function bindRowEvents(productId, item) {
                const qtyInput = item.row.querySelector('.cart-qty-input');
                const qtyHidden = item.row.querySelector('.cart-qty-hidden');
                const lineTotalSpan = item.row.querySelector('.cart-line-total');
                const removeBtn = item.row.querySelector('.cart-remove-btn');

                function updateLine() {
                    let qty = parseInt(qtyInput.value, 10);
                    if (isNaN(qty) || qty < 1) qty = 1;
                    if (qty > item.maxStock) qty = item.maxStock;
                    qtyInput.value = qty;
                    qtyHidden.value = qty;
                    item.qty = qty;
                    const lineTotal = qty * item.price;
                    lineTotalSpan.textContent = formatCurrency(lineTotal);
                    recalcTotal();
                }

                qtyInput.addEventListener('change', updateLine);
                qtyInput.addEventListener('blur', updateLine);

                removeBtn.addEventListener('click', function () {
                    cart.delete(productId);
                    item.row.remove();
                    ensureNotEmpty();
                    recalcTotal();
                });

                updateLine();
            }

            function addToCart(product) {
                const id = product.id;
                if (cart.has(id)) {
                    const existing = cart.get(id);
                    const qtyInput = existing.row.querySelector('.cart-qty-input');
                    qtyInput.value = Math.min(existing.qty + 1, existing.maxStock);
                    qtyInput.dispatchEvent(new Event('change'));
                    return;
                }

                const clone = rowTemplate.content.firstElementChild.cloneNode(true);
                const nameSpan = clone.querySelector('td div span:nth-child(1)');
                const refSpan = clone.querySelector('td div span:nth-child(2)');
                const productIdInput = clone.querySelector('.cart-product-id-input');
                const qtyInput = clone.querySelector('.cart-qty-input');
                const qtyHidden = clone.querySelector('.cart-qty-hidden');
                const maxStockInput = clone.querySelector('.cart-max-stock');
                const priceSpan = clone.querySelector('.cart-price');
                const priceInput = clone.querySelector('.cart-price-input');

                nameSpan.textContent = product.name;
                refSpan.textContent = product.reference;
                productIdInput.name = `items[${cartIndex}][product_id]`;
                qtyHidden.name = `items[${cartIndex}][quantity]`;
                priceInput.name = `items[${cartIndex}][unit_price]`;

                productIdInput.value = product.id;
                qtyInput.value = 1;
                qtyHidden.value = 1;
                maxStockInput.value = product.stock;
                priceSpan.textContent = formatCurrency(product.price);
                priceInput.value = product.price;

                cartBody.appendChild(clone);

                const cartItem = {
                    row: clone,
                    qty: 1,
                    maxStock: product.stock,
                    price: product.price,
                };

                cart.set(id, cartItem);
                bindRowEvents(id, cartItem);
                cartIndex += 1;
                ensureNotEmpty();
                recalcTotal();
            }

            productButtons.forEach((btn) => {
                btn.addEventListener('click', function () {
                    const data = this.getAttribute('data-product');
                    if (!data) return;
                    try {
                        const product = JSON.parse(data);
                        if (product.stock && product.stock > 0) {
                            addToCart(product);
                        }
                    } catch (e) {
                        console.error('Invalid product data', e);
                    }
                });
            });

            ensureNotEmpty();
            recalcTotal();
        });
    </script>
@endsection