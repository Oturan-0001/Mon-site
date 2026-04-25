<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{


    public function welcome(Request $request)
    {
        $products = Product::all();
        
        return view('welcome', compact('products'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::all();
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Stockage de l'image dans storage/app/public/products
        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $path,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produit ajouté !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        // Si une nouvelle image est téléchargée
        if ($request->hasFile('image')) {
            // On supprime l'ancienne image physiquement
            Storage::disk('public')->delete($product->image);
            // On enregistre la nouvelle
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update($request->except('image'));
        $product->save();

        return redirect()->route('products.index')->with('success', 'Produit mis à jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Supprimer l'image du stockage
        Storage::disk('public')->delete($product->image);
        // Supprimer l'entrée en base
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé !');
    }

    
public function bulkDelete(Request $request)
{
    $ids = $request->selected_products;

    if (!$ids || count($ids) === 0) {
        return back()->with('error', 'Aucun produit sélectionné');
    }

    $products = Product::whereIn('id', $ids)->get();

    foreach ($products as $product) {
        Storage::disk('public')->delete($product->image);
        $product->delete();
    }

    return back()->with('success', 'Produits supprimés avec succès');
}

}
