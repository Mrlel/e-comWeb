<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        $this->notifierAdmin($commande, $request, $panier);

        session()->forget('panier');
        session()->put('client_info', $request->only('nom', 'prenom', 'email', 'telephone'));

        return redirect()->route('commande.confirmation', $commande->id)
            ->with('success', 'Votre commande a bien été enregistrée.');
    }

    /**
     * Avertit l'admin par e-mail : plus de paiement en ligne, la commande
     * doit être traitée manuellement (contact client, livraison, encaissement).
     */
    protected function notifierAdmin(Commande $commande, Request $request, array $panier): void
    {
        $lignesTexte = collect($panier)
            ->map(fn ($item) => "- {$item['nom']} x{$item['quantite']} : " . number_format($item['prix'] * $item['quantite'], 0, ',', ' ') . ' FCFA')
            ->implode("\n");

        $totalFormate = number_format($commande->montant_total, 0, ',', ' ') . ' FCFA';

        $corps = <<<TEXT
Nouvelle commande reçue : {$commande->reference_commande}

Client : {$request->prenom} {$request->nom}
Email : {$request->email}
Téléphone : {$request->telephone}
Adresse de livraison : {$request->adresse_livraison}

Articles :
{$lignesTexte}

Total : {$totalFormate}

Merci de contacter le/la client(e) pour confirmer le paiement et la livraison.
TEXT;

        try {
            Mail::raw($corps, function ($mail) use ($commande) {
                $mail->to(config('mail.from.address'))
                    ->subject('Nouvelle commande — ' . $commande->reference_commande);
            });
        } catch (\Throwable $e) {
            Log::error('Échec notification admin nouvelle commande', [
                'commande_id' => $commande->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function confirmation($id)
    {
        $commande = Commande::with('ligneCommandes.produit')->findOrFail($id);

        return view('commande.confirmation', compact('commande'));
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
