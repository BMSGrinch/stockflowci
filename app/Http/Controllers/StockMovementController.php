<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $typeFilter = $request->query('movement_type');
        $query = StockMovement::with('product','user')->latest();

        if(in_array($typeFilter , ['entry','sale','adjustement','loss'],true)){
            $query->where('movement_type',$typeFilter);
        }

        $stocks =$query->paginate(10)->appends($request->only('movement_type'));
        // Page principale des mouvements de stock
        return view('stocks.index', compact('stocks','typeFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::where('is_active',1)->get();
        return view('stocks.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'product_id'=>'required|exists:products,id',
            'user_id'=>'required|exists:users,id',
            'movement_type'=>'required|in:entry,sale,adjustment,loss',
            'quantity'=>'required|integer',
            'note'=>'nullable|string|max:255',
        ]); 
        StockMovement::create($validated);
        return redirect()->route('stocks.index')->with('success', 'Créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMovement $stock)
    {
        //
        $stock->load('product','user');
        return view('stocks.info' , compact('stock'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMovement $stock)
    {
        //
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'supprimé avec succès');
    }
}
