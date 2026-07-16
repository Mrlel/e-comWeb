<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeniusPayService
{
    protected $apiKey;
    protected $apiSecret;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('GENIUS_PAY_KEY');
        $this->apiSecret = env('GENIUS_PAY_SECRET');
        $this->baseUrl = env('GENIUS_PAY_URL', 'https://pay.genius.ci/api/v1/merchant');
    }

    protected function headers()
    {
        return [
            'X-API-Key' => $this->apiKey,
            'X-API-Secret' => $this->apiSecret,
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Initier un paiement (Mode Checkout)
     */
    public function initierPaiement($amount, $description, $customer, $metadata = [])
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/payments', [
                'amount' => $amount,
                'description' => $description,
                'customer' => $customer,
                'metadata' => $metadata,
            ]);

        if ($response->successful()) {
            return $response->json('data');
        }

        \Log::error('GeniusPay init error', ['response' => $response->body()]);
        return null;
    }

    /**
     * Récupérer un paiement par référence
     */
    public function recupererPaiement($reference)
    {
        $response = Http::withHeaders($this->headers())
            ->get($this->baseUrl . '/payments/' . $reference);

        if ($response->successful()) {
            return $response->json('data');
        }

        return null;
    }
}