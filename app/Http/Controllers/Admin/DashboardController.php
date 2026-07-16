<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use App\Models\Paiement;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_commandes'  => Commande::count(),
            'commandes_payees' => Commande::where('statut', 'payé')->count(),
            'total_produits'   => Produit::count(),
            'total_clients'    => User::where('role', 'client')->count(),
            'chiffre_affaires' => Paiement::where('statut', 'réussi')->sum('montant'),
            'stock_faible'     => Produit::where('stock', '<=', 5)->count(),
        ];

        $dernieres_commandes = Commande::with('user')
            ->latest()->limit(8)->get();

        $produits_populaires = Produit::withCount('ligneCommandes')
            ->orderByDesc('ligne_commandes_count')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'dernieres_commandes', 'produits_populaires'));
    }
}
