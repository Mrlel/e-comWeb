<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookGeniusPayController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Vérifier la signature
        $signature = $request->header('X-Webhook-Signature');
        $timestamp = $request->header('X-Webhook-Timestamp');
        $event = $request->header('X-Webhook-Event');
        
        $payload = $request->getContent();
        $secret = env('GENIUS_PAY_SECRET');
        
        $expectedSignature = hash_hmac('sha256', $timestamp . '.' . $payload, $secret);
        
        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('Signature webhook GeniusPay invalide');
            return response()->json(['error' => 'Signature invalide'], 401);
        }
        
        // 2. Vérifier le timestamp (anti-replay)
        if (abs(time() - (int)$timestamp) > 300) {
            Log::warning('Timestamp webhook GeniusPay trop vieux');
            return response()->json(['error' => 'Timestamp invalide'], 401);
        }
        
        // 3. Traiter l'événement
        $data = $request->all();
        
        switch ($event) {
            case 'payment.success':
                $this->handlePaymentSuccess($data);
                break;
            case 'payment.failed':
                $this->handlePaymentFailed($data);
                break;
            case 'payment.expired':
                $this->handlePaymentExpired($data);
                break;
        }
        
        return response()->json(['status' => 'ok']);
    }
    
    protected function handlePaymentSuccess($data)
    {
        $reference = $data['reference'];
        $metadata = $data['metadata'] ?? [];
        
        $commandeId = $metadata['commande_id'] ?? null;
        $commande = Commande::find($commandeId);

        if ($commande && $commande->statut === 'en_attente') {
            $commande->update(['statut' => 'payé']);

            Paiement::where('commande_id', $commande->id)->update([
                'statut' => 'réussi',
                'transaction_id' => $reference,
            ]);

            Log::info('Paiement GeniusPay réussi', [
                'commande_id' => $commande->id,
                'reference_geniuspay' => $reference,
                'montant' => $data['amount']
            ]);
        }
    }

    protected function handlePaymentFailed($data)
    {
        $metadata = $data['metadata'] ?? [];
        $commandeId = $metadata['commande_id'] ?? null;

        Paiement::whereHas('commande', fn($q) => $q->where('id', $commandeId))
            ->update(['statut' => 'échoué']);

        Log::warning('Paiement GeniusPay échoué', [
            'commande_id' => $commandeId,
            'reference' => $data['reference']
        ]);
    }

    protected function handlePaymentExpired($data)
    {
        $metadata = $data['metadata'] ?? [];
        $commandeId = $metadata['commande_id'] ?? null;

        if ($commandeId) {
            Commande::where('id', $commandeId)
                ->where('statut', 'en_attente')
                ->update(['statut' => 'annulé']);

            Paiement::whereHas('commande', fn($q) => $q->where('id', $commandeId))
                ->update(['statut' => 'échoué']);
        }

        Log::info('Paiement GeniusPay expiré', ['reference' => $data['reference']]);
    }
}