<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use App\Services\GeniusPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    protected $geniusPay;

    public function __construct(GeniusPayService $geniusPay)
    {
        $this->geniusPay = $geniusPay;
    }

    /**
     * Page de paiement pour une commande
     */
    public function show($commandeId)
    {
        $commande = Commande::where('user_id', Auth::id())
            ->where('id', $commandeId)
            ->firstOrFail();

        if ($commande->statut !== 'en_attente') {
            return redirect()->route('boutique')
                ->with('error', 'Cette commande ne peut plus être payée.');
        }

        return view('paiement.checkout', compact('commande'));
    }

    /**
     * Initier le paiement et rediriger vers GeniusPay
     */
    public function initier(Request $request, $commandeId)
    {
        $commande = Commande::where('user_id', Auth::id())
            ->where('id', $commandeId)
            ->firstOrFail();

        if ($commande->statut !== 'en_attente') {
            return back()->with('error', 'Cette commande ne peut plus être payée.');
        }

        $user = Auth::user();

        $paiement = $this->geniusPay->initierPaiement(
            amount: $commande->montant_total,
            description: "Commande #{$commande->reference_commande}",
            customer: [
                'name' => trim($user->prenom . ' ' . $user->nom) ?: 'Client',
                'email' => $user->email,
                'phone' => $user->telephone ?? '',
                'country' => 'CI', // Côte d'Ivoire
            ],
            metadata: [
                'commande_id' => $commande->id,
                'user_id' => $user->id,
                'reference_commande' => $commande->reference_commande,
            ]
        );

        if ($paiement && isset($paiement['checkout_url'])) {
            Paiement::updateOrCreate(
                ['commande_id' => $commande->id],
                [
                    'reference_paiement' => $paiement['reference'],
                    'montant' => $commande->montant_total,
                    'methode' => 'mobile_money',
                    'statut' => 'en_attente',
                    'provider' => 'geniuspay',
                ]
            );

            return redirect($paiement['checkout_url']);
        }

        return back()->with('error', 'Impossible d\'initier le paiement. Veuillez réessayer.');
    }

    /**
     * Vérifier le statut après retour de GeniusPay
     */
    public function retour(Request $request)
    {
        $reference = $request->get('reference');

        $paiementLocal = $reference ? Paiement::where('reference_paiement', $reference)->first() : null;

        if (!$paiementLocal) {
            return redirect()->route('boutique')->with('error', 'Référence de paiement invalide.');
        }

        $commande = $paiementLocal->commande;
        $paiement = $this->geniusPay->recupererPaiement($reference);

        if ($paiement && $paiement['status'] === 'completed') {
            $commande->update(['statut' => 'payé']);
            $paiementLocal->update([
                'statut' => 'réussi',
                'transaction_id' => $reference,
            ]);

            return view('paiement.success', compact('commande'));
        }

        $paiementLocal->update(['statut' => 'échoué']);

        return redirect()->route('paiement.echec', $commande->id)
            ->with('error', 'Le paiement a échoué. Veuillez réessayer.');
    }

    /**
     * Page d'échec de paiement
     */
    public function echec($commandeId)
    {
        $commande = Commande::where('user_id', Auth::id())
            ->where('id', $commandeId)
            ->firstOrFail();

        return view('paiement.cancel', compact('commande'));
    }
}
