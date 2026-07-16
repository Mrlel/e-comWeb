<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with('categorie')->latest()->paginate(15);
        return view('admin.produits.index', compact('produits'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('admin.produits.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'          => 'required|string|max:255',
            'description'  => 'nullable|string',
            'prix'         => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($data);
        return redirect()->route('admin.produits.index')->with('success', 'Produit créé avec succès');
    }

    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        $categories = Categorie::all();
        return view('admin.produits.form', compact('produit', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $data = $request->validate([
            'nom'          => 'required|string|max:255',
            'description'  => 'nullable|string',
            'prix'         => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($data);
        return redirect()->route('admin.produits.index')->with('success', 'Produit mis à jour');
    }

    public function destroy($id)
    {
        Produit::findOrFail($id)->delete();
        return redirect()->route('admin.produits.index')->with('success', 'Produit supprimé');
    }
}
