<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index(Request $request)
    {
        $query = Commande::with('user', 'paiement')->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $commandes = $query->paginate(15);
        return view('admin.commandes.index', compact('commandes'));
    }

    public function show($id)
    {
        $commande = Commande::with('user', 'ligneCommandes.produit', 'paiement', 'livraison')->findOrFail($id);
        return view('admin.commandes.show', compact('commande'));
    }

    public function updateStatut(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $request->validate(['statut' => 'required|in:en_attente,payé,annulé']);
        $commande->update(['statut' => $request->statut]);
        return redirect()->back()->with('success', 'Statut mis à jour');
    }
}
