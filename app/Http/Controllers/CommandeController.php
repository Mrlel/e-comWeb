<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommandeController extends Controller
{
    public function checkout()
    {
        $panier = session()->get('panier', []);
        
        if (empty($panier)) {
            return redirect()->route('panier')->with('error', 'Votre panier est vide');
        }
        
        $total = collect($panier)->sum(fn($item) => $item['prix'] * $item['quantite']);
        
        return view('commande.checkout', compact('panier', 'total'));
    }

    public function passer(Request $request)
    {
        $request->validate([
            'adresse_livraison' => 'required|string|min:10',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email',
            'telephone' => 'required|string',
        ]);

        $panier = session()->get('panier', []);
        
        if (empty($panier)) {
            return redirect()->route('panier')->with('error', 'Votre panier est vide');
        }

        $total = collect($panier)->sum(fn($item) => $item['prix'] * $item['quantite']);

        // Créer la commande
        $commande = Commande::create([
            'user_id' => auth()->id() ?? 1, // guest ou user connecté
            'reference_commande' => 'CMD-' . strtoupper(Str::random(8)),
            'montant_total' => $total,
            'statut' => 'en_attente',
            'adresse_livraison' => $request->adresse_livraison,
        ]);

        // Créer les lignes de commande
        foreach ($panier as $produitId => $item) {
            LigneCommande::create([
                'commande_id' => $commande->id,
                'produit_id' => $produitId,
                'quantite' => $item['quantite'],
                'prix_unitaire' => $item['prix'],
                'sous_total' => $item['prix'] * $item['quantite'],
            ]);
        }

        // Stocker les infos client en session pour le paiement
        session()->put('client_info', $request->only('nom', 'prenom', 'email', 'telephone'));

        return redirect()->route('paiement.show', $commande->id);
    }

    public function mesCommandes()
    {
        $commandes = Commande::where('user_id', auth()->id())
            ->with('ligneCommandes.produit', 'paiement')
            ->latest()
            ->get();
        
        return view('commande.mes-commandes', compact('commandes'));
    }

    public function detail($id)
    {
        $commande = Commande::where('user_id', auth()->id())
            ->with('ligneCommandes.produit', 'paiement', 'livraison')
            ->findOrFail($id);

        return view('commande.detail', compact('commande'));
    }
}
