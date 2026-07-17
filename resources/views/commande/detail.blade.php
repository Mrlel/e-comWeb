@extends('layouts.app')

@section('title', 'Commande ' . $commande->reference_commande)
@section('page', 'compte')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">Mon compte</p>
    <h1>Commande {{ $commande->reference_commande }}</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      <a href="{{ route('commande.mes-commandes') }}">Mes commandes</a>
      <span class="sep">/</span>
      <span class="current">{{ $commande->reference_commande }}</span>
    </div>
  </div>
</section>

<section class="checkout-section">
  <div class="container-xl px-3 px-lg-4">
    <div class="order-detail-grid">
      <div>
        <div class="order-detail-card">
          <h2>Articles commandés</h2>
          @foreach($commande->ligneCommandes as $ligne)
            <div class="order-line">
              <img src="{{ $ligne->produit && $ligne->produit->image ? asset('storage/'.$ligne->produit->image) : 'https://placehold.co/80x84/f2c3ce/7a3c4d?text=' . urlencode($ligne->produit->nom ?? 'Produit') }}" alt="">
              <div class="order-line-info">
                <strong>{{ $ligne->produit->nom ?? 'Produit supprimé' }}</strong>
                <span>{{ $ligne->quantite }} &times; {{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</span>
              </div>
              <span class="order-line-total">{{ number_format($ligne->sous_total, 0, ',', ' ') }} FCFA</span>
            </div>
          @endforeach
        </div>

        @if($commande->livraison)
          <div class="order-detail-card">
            <h2>Livraison</h2>
            <div class="order-meta-row"><span>Adresse</span><strong>{{ $commande->livraison->adresse }}</strong></div>
            @if($commande->livraison->ville)
              <div class="order-meta-row"><span>Ville</span><strong>{{ $commande->livraison->ville }}</strong></div>
            @endif
            <div class="order-meta-row"><span>Statut</span><strong>{{ ucfirst($commande->livraison->statut) }}</strong></div>
          </div>
        @endif
      </div>

      <aside class="cart-summary">
        <h2>Résumé</h2>
        <div class="order-meta-row"><span>Statut</span><span class="order-status {{ $commande->statut }}">{{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</span></div>
        <div class="order-meta-row"><span>Date</span><strong>{{ $commande->created_at->format('d/m/Y à H:i') }}</strong></div>
        <div class="order-meta-row"><span>Adresse</span><strong style="text-align:right; max-width: 60%;">{{ $commande->adresse_livraison }}</strong></div>
        @if($commande->paiement)
          <div class="order-meta-row"><span>Paiement</span><strong>{{ ucfirst($commande->paiement->statut) }}</strong></div>
        @endif
        <div class="cart-summary-total">
          <span>Total</span>
          <strong>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</strong>
        </div>
      </aside>
    </div>
  </div>
</section>

@endsection
