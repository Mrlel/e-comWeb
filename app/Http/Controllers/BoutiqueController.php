<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class BoutiqueController extends Controller
{
    public function index()
    {
        $produits = Produit::with(['categorie', 'avis'])->latest()->paginate(12);
        $categories = Categorie::withCount('produits')->get();

        return view('boutique.index', compact('produits', 'categories'));
    }

    public function show($id)
    {
        $produit = Produit::with(['categorie', 'avis.user'])->findOrFail($id);
        $produitsLies = Produit::where('categorie_id', $produit->categorie_id)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();
        
        return view('boutique.show', compact('produit', 'produitsLies'));
    }

    public function categorie($id)
    {
        $categorie = Categorie::findOrFail($id);
        $produits = Produit::where('categorie_id', $id)->paginate(12);
        $categories = Categorie::withCount('produits')->get();
        
        return view('boutique.categorie', compact('categorie', 'produits', 'categories'));
    }
}
