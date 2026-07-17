@extends('layouts.app')

@section('title', 'Commande confirmée')
@section('page', 'panier')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">Boutique</p>
    <h1>Commande confirmée</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      <span class="current">{{ $commande->reference_commande }}</span>
    </div>
  </div>
</section>

<section class="payment-section">
  <div class="container-xl px-3 px-lg-4">
    <div class="payment-card">
      <div class="payment-icon-badge is-success">
        <svg width="30" height="30" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 5 5L23 6"/></svg>
      </div>
      <h1>Merci pour votre commande !</h1>
      <p>
        Votre commande <strong>{{ $commande->reference_commande }}</strong> d'un montant de
        <strong style="color: var(--primary-dark);">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</strong>
        a bien été enregistrée. Notre équipe va vous contacter très prochainement pour confirmer
        les modalités de paiement et de livraison.
      </p>

      <div class="cart-page-table" style="text-align:left; margin-bottom: 1.8rem;">
        @foreach($commande->ligneCommandes as $ligne)
          <div class="checkout-summary-item">
            <span>{{ $ligne->quantite }} &times; {{ $ligne->produit->nom ?? 'Produit' }}</span>
            <span>{{ number_format($ligne->sous_total, 0, ',', ' ') }} FCFA</span>
          </div>
        @endforeach
      </div>

      <a href="{{ route('boutique') }}" class="btn-primary-brand">
        Continuer mes achats
        <svg width="16" height="16" class="icon"><use href="#icon-chevron-right"></use></svg>
      </a>
    </div>
  </div>
</section>

@endsection
