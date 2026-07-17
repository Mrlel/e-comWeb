@extends('layouts.app')

@section('title', 'Mon panier')
@section('page', 'panier')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">Boutique</p>
    <h1>Mon panier</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      <span class="current">Mon panier</span>
    </div>
  </div>
</section>

<section class="cart-page">
  <div class="container-xl px-3 px-lg-4">

    @if(session('success'))
      <div class="form-alert success">{{ session('success') }}</div>
    @endif

    @if(empty($panier))
      <div class="cart-empty">
        <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.4"><use href="#icon-bag"></use></svg>
        <p>Votre panier est vide pour le moment.</p>
        <a href="{{ route('boutique') }}" class="btn-primary-brand">
          Continuer mes achats
          <svg width="16" height="16" class="icon"><use href="#icon-chevron-right"></use></svg>
        </a>
      </div>
    @else
      <div class="cart-page-grid">
        <div class="cart-page-table">
          @foreach($panier as $id => $item)
            <div class="cart-page-row">
              <img src="{{ !empty($item['image']) ? asset('storage/'.$item['image']) : 'https://placehold.co/80x84/f2c3ce/7a3c4d?text='.urlencode($item['nom']) }}" alt="{{ $item['nom'] }}">
              <div class="cart-page-row-info">
                <h3>{{ $item['nom'] }}</h3>
                <span class="unit-price">{{ $item['quantite'] }} &times; {{ number_format($item['prix'], 0, ',', ' ') }} FCFA</span>
              </div>
              <span class="line-total">{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} FCFA</span>
              <form action="{{ route('panier.retirer', $id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="cart-page-remove" aria-label="Retirer {{ $item['nom'] }} du panier">
                  <svg width="16" height="16" class="icon"><use href="#icon-close"></use></svg>
                </button>
              </form>
            </div>
          @endforeach

          <form action="{{ route('panier.vider') }}" method="POST" style="margin-top: 0.5rem;">
            @csrf
            @method('DELETE')
            <button type="submit" class="link-arrow" style="color: var(--text-soft);">Vider le panier</button>
          </form>
        </div>

        <aside class="cart-summary">
          <h2>Récapitulatif</h2>
          <div class="cart-summary-row">
            <span>Sous-total</span>
            <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
          </div>
          <div class="cart-summary-row">
            <span>Livraison</span>
            <span>{{ $total >= 30000 ? 'Offerte' : 'Calculée à l\'étape suivante' }}</span>
          </div>
          <div class="cart-summary-total">
            <span>Total</span>
            <strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong>
          </div>
          <a href="{{ route('commande.checkout') }}" class="btn-primary-brand">
            Passer la commande
            <svg width="16" height="16" class="icon"><use href="#icon-chevron-right"></use></svg>
          </a>
        </aside>
      </div>
    @endif

  </div>
</section>

@endsection
