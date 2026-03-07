<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::withCount('products')->paginate(10);
        // Page principale des fournisseurs avec le nombre de produits pour chaque fournisseur pour eviter le N+1
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('suppliers.create')->with ('success' , 'Fournisseur ajouté avec succès');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name'=>'required|string|max:150',
            'email'=>'nullable|string|max:150|unique:suppliers',
            'phone'=>'nullable|string|max:20',
        ]);
        Supplier::create($validated);
        return redirect()->route('suppliers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
        $supplier->load('products'); // Ca va me permettre de récup directement la liste des produits qui sont attribués à un fornisseur dans la page suppliers.info
        return view('suppliers.info',compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
        return view('suppliers.edit',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
        $validated = $request->validate([
            'name'=>'required|string|max:150',
            'email'=>'nullable|string|max:150|unique:suppliers,email,'.$supplier->id,
            'phone'=>'nullable|string|max:20',
        ]);
        $supplier->update($validated);
        return redirect()->route('suppliers.index')->with('success','fournisseur mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success','fournisseur supprimé avec succès');
    }
}
