<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function index()
    {
        $panier = session()->get('panier', []);
        $total = 0;
        
        foreach ($panier as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        
        return view('panier.index', compact('panier', 'total'));
    }

    public function ajouter(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);
        $quantite = max(1, (int) $request->input('quantite', 1));
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]['quantite'] += $quantite;
        } else {
            $panier[$id] = [
                'nom' => $produit->nom,
                'prix' => $produit->prix,
                'quantite' => $quantite,
                'image' => $produit->image
            ];
        }

        session()->put('panier', $panier);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cartCount' => collect($panier)->sum('quantite'),
                'cartTotal' => collect($panier)->sum(fn ($i) => $i['prix'] * $i['quantite']),
                'item' => array_merge(['id' => $id], $panier[$id]),
                'message' => 'Produit ajouté au panier',
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier');
    }

    public function retirer(Request $request, $id)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            unset($panier[$id]);
            session()->put('panier', $panier);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cartCount' => collect($panier)->sum('quantite'),
                'cartTotal' => collect($panier)->sum(fn ($i) => $i['prix'] * $i['quantite']),
                'isEmpty' => empty($panier),
            ]);
        }

        return redirect()->back()->with('success', 'Produit retiré du panier');
    }

    public function vider()
    {
        session()->forget('panier');
        return redirect()->back()->with('success', 'Panier vidé');
    }
}
