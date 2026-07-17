@extends('layouts.app')

@section('title', 'Finaliser ma commande')
@section('page', 'panier')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">Boutique</p>
    <h1>Finaliser ma commande</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      <a href="{{ route('panier') }}">Mon panier</a>
      <span class="sep">/</span>
      <span class="current">Commande</span>
    </div>
  </div>
</section>

<section class="checkout-section">
  <div class="container-xl px-3 px-lg-4">

    @if(session('error'))
      <div class="form-alert error">{{ session('error') }}</div>
    @endif

    <div class="checkout-grid">
      <div class="checkout-form-card">
        <h2>Informations de livraison</h2>

        <form action="{{ route('commande.passer') }}" method="POST">
          @csrf
          <div class="form-row-2">
            <div class="form-field">
              <label for="prenom">Prénom</label>
              <input type="text" id="prenom" name="prenom" value="{{ old('prenom', auth()->user()->prenom ?? '') }}" required>
              @error('prenom')<div class="form-error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
              <label for="nom">Nom</label>
              <input type="text" id="nom" name="nom" value="{{ old('nom', auth()->user()->nom ?? '') }}" required>
              @error('nom')<div class="form-error-msg">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="form-row-2">
            <div class="form-field">
              <label for="email">Adresse e-mail</label>
              <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
              @error('email')<div class="form-error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
              <label for="telephone">Téléphone</label>
              <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', auth()->user()->telephone ?? '') }}" placeholder="+225 07 00 00 00 00" required>
              @error('telephone')<div class="form-error-msg">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="form-field">
            <label for="adresse_livraison">Adresse de livraison</label>
            <textarea id="adresse_livraison" name="adresse_livraison" placeholder="Quartier, rue, indications utiles pour le livreur…" required>{{ old('adresse_livraison') }}</textarea>
            @error('adresse_livraison')<div class="form-error-msg">{{ $message }}</div>@enderror
          </div>

          <button type="submit" class="btn-primary-brand" style="width:100%; justify-content:center; margin-top: 0.5rem;">
            Continuer vers le paiement
            <svg width="16" height="16" class="icon"><use href="#icon-chevron-right"></use></svg>
          </button>
        </form>
      </div>

      <aside class="cart-summary">
        <h2>Votre commande</h2>
        @foreach($panier as $item)
          <div class="checkout-summary-item">
            <span>{{ $item['quantite'] }} &times; {{ $item['nom'] }}</span>
            <span>{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} FCFA</span>
          </div>
        @endforeach
        <div class="cart-summary-total">
          <span>Total</span>
          <strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong>
        </div>
      </aside>
    </div>

  </div>
</section>

@endsection
