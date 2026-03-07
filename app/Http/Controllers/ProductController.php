<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource. on affiche la liste des produits
     */
    public function index()
    {
        // On charge les fournisseurs pour éviter le N+1 dans la vue
        $products = Product::with('supplier')->paginate(15);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource. tu retournes juste la vue qui va afficher le formulaire pour ajouter un nouveau produit
     */
    public function create()
    {
        //
        $suppliers =Supplier::all();
        return view('products.create',compact('suppliers'));
    }
    

    /**
     * Store a newly created resource in storage. Ici on crée une nouveau produit via un formulaire.
     */
    public function store(Request $request)
    {
        //
       $validated = $request->validate([
            'name'=>'required|string|max:150',
            'supplier_id'=>'nullable|exists:suppliers,id',
            'reference'=>'required|string|max:50|unique:products',
            'category'=>'nullable|string|max:100',
            'purchase_price'=>'required|numeric|min:0',
            'selling_price'=>'required|numeric|min:0',
            'quantity'=>'required|integer|min:0',
            'alert_threshold'=>'required|integer|min:0',
       ]);
       Product::create($validated);

       return redirect()->route('products.index')->with ('success' , 'Produit ajouté avec succès');
    }

    /**
     * Display the specified resource. Pour récupéer une ressource. Ca sera utile pour afficher les détails d'un produits
     */
    public function show(Product $product)
    {
        //
        $product->load('supplier' , 'StockMovements');
        return view('products.details', compact('product'));
    }

    /**
     * Show the form for editing the specified resource. C'est surtout pour afficher des propriété propre à un produit sinon c'est comme xreate
     */
    public function edit(Product $product)
    {
        $suppliers = Supplier::all();
        return view('products.edit',compact('product','suppliers') );
    }

    /**
     * Update the specified resource in storage. C'est store mais là on met à jour le produits donc il faut une confirmation des données 
     */
    public function update(Request $request, Product $product)
    {
        //
        $validated = $request->validate([
            'name'=>'required|string|max:150',
            'supplier_id'=>'nullable|exists:suppliers,id',
            'reference'=>'required|string|max:50|unique:products,reference,'.$product->id ,
            'category'=>'nullable|string|max:100',
            'purchase_price'=>'required|numeric|min:0',
            'selling_price'=>'required|numeric|min:0',
            'quantity'=>'required|integer|min:0',
            'alert_threshold'=>'required|integer|min:0',
       ]);
        $product->update($validated);

        return redirect()->route('products.index')->with ('success' , 'Produit mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.Supprime un produit 
     */
    public function destroy(Product $product)
    {
        //
        $product ->delete();
        return redirect()->route('products.index')->with('success' , 'Produit supprimé avec succès');
    }
}
