<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paymentFilter = $request->query('payment_method'); // ça c'est pour lire l'url 
        // y a pas le get ici parce qu'il faut contruire la requête sans l'exécuter vu qu'on doit faire des vérification sur l'url c

        $salesQuery = Sale::with('user')
            ->withCount('saleItems') // compte le nombre d'articles vendus pour éviter le N+1
            ->orderByDesc('created_at');

        if (in_array($paymentFilter, ['cash', 'mobile_money', 'carte'], true)) {
            $salesQuery->where('payment_method', $paymentFilter);
        } // le if c'est pour appliquer le filtre qui s'il est nécessaire 
        // le in_array aussi c'est pour check si on a vraiment ces valeurs dans les paymentMethod

        $sales = $salesQuery->paginate(10)->appends($request->only('payment_method')); //appends c'est pour conderver la pagination par filtre entre les page.

        return view('sales.index', compact('sales', 'paymentFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::where('is_active', 1)->where('quantity', '>', 0)->get();
        return view('sales.create', compact('products')); //ici on doit check d'ab si le produit peut être vendu 
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        // pour valider les données
        $validated = $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,mobile_money,carte',
        ]);

        try {
            // Pour la sécu du soit tout passe soit rien ne passe
            return DB::transaction(function () use ($request, $validated) {
                $sale = Sale::create([
                    'user_id' => auth()->id(), // auth()->id() c'est pour récupérer l'id de l'utilisateur connecté. S'il est en session
                    'total_amount' => $validated['total_amount'],
                    'payment_method' => $validated['payment_method'],
                ]); // création de la vente 


                $totalPrice = 0;

                if (empty($request->items)) {
                    throw new \Exception('Aucun produit dans la vente');
                }//petite vérif avant de toucher aux produits mdr

                foreach ($request->items as $item) {
                    $product = Product::find($item['product_id']);

                    if ($product->quantity < $item['quantity']) {
                        throw new \Exception('Stock insuffisant pour' . $product->name);
                    }//vérifier si le stock est disponible pour éviter de se retrouver avec un stock négatif 

                    $sale->saleItems()->create([
                        'product_id' => $product->id,
                        'unit_price' => $product->selling_price,
                        'quantity' => $item['quantity'],

                    ]); //créer le saleitem

                    $product->decrement('quantity', $item['quantity']); //décrémenter la quantité du produit

                    $product->stockMovements()->create([
                        'user_id' => auth()->id(), // auth()->id() c'est pour récupérer l'id de l'utilisateur connecté.
                        'movement_type' => 'sale',
                        'quantity' => -$item['quantity'],
                        'note' => 'Vente#' . $sale->id,
                    ]); //Créer un nouveau mouvement de stock

                    $totalPrice += $product->selling_price * $item['quantity'];

                }

                if (abs($totalPrice - (float) $validated['total_amount']) > 0.01) {
                    throw new \Exception('Montant total incorrect');
                }//Pour vérifier que j'ai pas d'incohérence sur les prix totaux


                return redirect()->route('sales.index')->with('success', 'Vente validée avec succès');
            });

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'une erreur est survenue lors de la création de la vente: ' . $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
        $sale->load('user', 'saleItems.product');// Le .product est pour charger le produit associé à la vente pour eviter le N+1
        return view('sales.detail', compact('sale'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'supprimé avec succes');
    }
}
