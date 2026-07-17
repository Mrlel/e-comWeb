<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Le Plan Des Copines') — Boutique féminine premium</title>
<meta name="description" content="Le Plan Des Copines — vêtements, chaussures, sacs, accessoires et beauté pour révéler la femme qui est en vous.">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdn.jsdelivr.net">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<link rel="icon" href="{{ asset('favicon.ico') }}">
@stack('styles')
</head>
<body data-page="@yield('page', 'accueil')">

<svg style="display:none" aria-hidden="true">
  <symbol id="icon-truck" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 3h13v13H1z"/><path d="M14 8h4l4 4v4h-8V8z"/><circle cx="6" cy="18.5" r="1.8"/><circle cx="17.5" cy="18.5" r="1.8"/></symbol>
  <symbol id="icon-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.5 2.1L8 9.7a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.5 2.7.6a2 2 0 0 1 1.7 2z"/></symbol>
  <symbol id="icon-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.35-4.35"/></symbol>
  <symbol id="icon-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></symbol>
  <symbol id="icon-heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></symbol>
  <symbol id="icon-bag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8h12l1 13H5L6 8z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/></symbol>
  <symbol id="icon-star" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2.5l2.9 6.4 6.8.7-5.1 4.7 1.5 6.9L12 17.8l-6.1 3.4 1.5-6.9-5.1-4.7 6.8-.7L12 2.5z"/></symbol>
  <symbol id="icon-quote" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M9.6 5.4C6 6.7 3.6 9.8 3.6 13.6c0 3 2 5.2 4.6 5.2 2.2 0 3.8-1.7 3.8-3.8 0-2-1.4-3.5-3.3-3.5-.4 0-.7 0-1 .1.3-1.9 1.9-3.7 4.3-4.6L9.6 5.4zm10 0c-3.6 1.3-6 4.4-6 8.2 0 3 2 5.2 4.6 5.2 2.2 0 3.8-1.7 3.8-3.8 0-2-1.4-3.5-3.3-3.5-.4 0-.7 0-1 .1.3-1.9 1.9-3.7 4.3-4.6l-2.4-1.6z"/></symbol>
  <symbol id="icon-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 5v6c0 5 3.4 8.7 8 11 4.6-2.3 8-6 8-11V5l-8-3z"/><path d="m9 12 2 2 4-4"/></symbol>
  <symbol id="icon-rotate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v5h5"/></symbol>
  <symbol id="icon-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></symbol>
  <symbol id="icon-pin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></symbol>
  <symbol id="icon-chevron-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></symbol>
  <symbol id="icon-chevron-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></symbol>
  <symbol id="icon-menu" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M3 12h18M3 18h18"/></symbol>
  <symbol id="icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></symbol>
  <symbol id="icon-flower" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2c1.7 1.6 1.7 4 0 5.6C10.3 6 10.3 3.6 12 2zM12 22c-1.7-1.6-1.7-4 0-5.6 1.7 1.6 1.7 4 0 5.6zM2 12c1.6-1.7 4-1.7 5.6 0C6 13.7 3.6 13.7 2 12zM22 12c-1.6 1.7-4 1.7-5.6 0 1.6-1.7 4-1.7 5.6 0z"/><circle cx="12" cy="12" r="2.4"/></symbol>
  <symbol id="icon-home" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 9-8 9 8"/><path d="M5 10v10h14V10"/></symbol>
  <symbol id="icon-grid" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="8" height="8" rx="1.5"/><rect x="13" y="3" width="8" height="8" rx="1.5"/><rect x="3" y="13" width="8" height="8" rx="1.5"/><rect x="13" y="13" width="8" height="8" rx="1.5"/></symbol>
  <symbol id="icon-facebook" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 8h2V4h-2a4 4 0 0 0-4 4v2H9v4h2v6h4v-6h2.5l.5-4H15V8z"/></symbol>
  <symbol id="icon-instagram" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/></symbol>
  <symbol id="icon-tiktok" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3v11.2a3.3 3.3 0 1 1-3.3-3.3c.3 0 .6 0 .9.1V8a6.3 6.3 0 1 0 6.3 6.3V9.6A6.6 6.6 0 0 0 21 11V8a4 4 0 0 1-4-4h-3z"/></symbol>
  <symbol id="icon-whatsapp" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20l1.3-4A8 8 0 1 1 8 18.7L4 20z"/><path d="M8.5 9.5c0 3.5 2.5 6 6 6"/></symbol>
</svg>

@php
    $panier = session('panier', []);
    $cartCount = collect($panier)->sum('quantite');
@endphp

<div class="topbar">
  <div class="container-xl px-3 px-lg-4">
    <div class="topbar-item">
      <svg width="16" height="16" class="icon"><use href="#icon-truck"></use></svg>
      <span>Livraison offerte dès 30 000 FCFA d'achat</span>
    </div>
    <a href="tel:+22507000000" class="topbar-item contact-line">
      <svg width="14" height="14" class="icon"><use href="#icon-phone"></use></svg>
      <span class="long">Service client :</span> +225 07 00 00 00 00
    </a>
  </div>
</div>

<header class="site-header">
  <div class="navbar-brand-wrap">
    <div class="container-xl px-3 px-lg-4">
      <div class="navbar-main">

        <a href="{{ route('boutique') }}" class="logo">
          <img src="{{ asset('lpdc-logo0.png') }}" alt="Le Plan Des Copines" class="logo-img">
        </a>

        <nav class="nav-links" aria-label="Navigation principale">
          <a href="{{ route('boutique') }}" data-nav-link="accueil">Accueil</a>
          <a href="{{ route('boutique.produits') }}" data-nav-link="produits">Produits</a>
          <a href="{{ route('boutique') }}#categories" data-nav-link="nouveautes">Nouveautés</a>
          <a href="{{ route('a-propos') }}" data-nav-link="a-propos">À propos</a>
          <a href="{{ route('contact') }}" data-nav-link="contact">Contacts</a>
        </nav>

        <div class="nav-actions">
          <button class="icon-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#searchPanel" aria-controls="searchPanel" aria-label="Ouvrir la recherche">
            <svg width="19" height="19" class="icon"><use href="#icon-search"></use></svg>
          </button>

          @auth
            <a href="{{ route('commande.mes-commandes') }}" class="icon-btn hide-mobile" aria-label="Mon compte">
              <svg width="19" height="19" class="icon"><use href="#icon-user"></use></svg>
            </a>
          @else
            <a href="{{ route('login') }}" class="icon-btn hide-mobile" aria-label="Mon compte">
              <svg width="19" height="19" class="icon"><use href="#icon-user"></use></svg>
            </a>
          @endauth

          <button class="icon-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartPanel" aria-controls="cartPanel" aria-label="Mon panier ({{ $cartCount }} article(s))">
            <svg width="19" height="19" class="icon"><use href="#icon-bag"></use></svg>
            <span class="badge-count" data-cart-count>{{ $cartCount }}</span>
          </button>

          <button class="hamburger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Ouvrir le menu">
            <svg width="22" height="22" class="icon"><use href="#icon-menu"></use></svg>
          </button>
        </div>

      </div>
    </div>
  </div>
</header>

<div class="offcanvas offcanvas-end mobile-menu" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header">
    <span class="logo" id="mobileMenuLabel">
      <img src="{{ asset('logo-lpdc-trimmed.png') }}" alt="Le Plan Des Copines" class="logo-img">
    </span>
    <button type="button" class="icon-btn" data-bs-dismiss="offcanvas" aria-label="Fermer le menu">
      <svg width="18" height="18" class="icon"><use href="#icon-close"></use></svg>
    </button>
  </div>
  <div class="offcanvas-body">
    <a href="{{ route('boutique') }}" data-nav-link="accueil">Accueil</a>
    <a href="{{ route('boutique.produits') }}" data-nav-link="produits">Produits</a>
    <a href="{{ route('boutique') }}#categories" data-nav-link="nouveautes">Nouveautés</a>
    <a href="{{ route('a-propos') }}" data-nav-link="a-propos">À propos</a>
    <a href="{{ route('contact') }}" data-nav-link="contact">Contacts</a>
    @auth
      <a href="{{ route('commande.mes-commandes') }}">Mon compte</a>
    @else
      <a href="{{ route('login') }}">Mon compte</a>
    @endauth
  </div>
</div>

<div class="offcanvas offcanvas-end search-panel" tabindex="-1" id="searchPanel" aria-labelledby="searchPanelLabel">
  <div class="offcanvas-header">
    <h2 class="offcanvas-title" id="searchPanelLabel">Rechercher</h2>
    <button type="button" class="icon-btn" data-bs-dismiss="offcanvas" aria-label="Fermer la recherche">
      <svg width="18" height="18" class="icon"><use href="#icon-close"></use></svg>
    </button>
  </div>
  <div class="offcanvas-body">
    <form role="search" action="{{ route('boutique.produits') }}" method="GET" class="search-panel-form">
      <label for="search-panel-input" class="visually-hidden">Rechercher un produit</label>
      <input type="search" name="q" id="search-panel-input" class="form-control" placeholder="Rechercher une robe, un sac…">
      <button type="submit" class="btn-rose">Rechercher</button>
    </form>
  </div>
</div>

<div class="offcanvas offcanvas-end cart-panel" tabindex="-1" id="cartPanel" aria-labelledby="cartPanelLabel">
  <div class="offcanvas-header">
    <h2 class="offcanvas-title" id="cartPanelLabel" data-cart-title>Mon panier ({{ $cartCount }})</h2>
    <button type="button" class="icon-btn" data-bs-dismiss="offcanvas" aria-label="Fermer le panier">
      <svg width="18" height="18" class="icon"><use href="#icon-close"></use></svg>
    </button>
  </div>
  <div class="offcanvas-body" data-cart-panel-body>
    <p class="cart-panel-empty" @if(!empty($panier)) hidden @endif data-cart-empty>Votre panier est vide.</p>
    <ul class="cart-panel-list" @if(empty($panier)) hidden @endif data-cart-list>
      @foreach($panier as $id => $item)
        <li class="cart-panel-item" data-cart-item="{{ $id }}">
          <img src="{{ !empty($item['image']) ? asset('storage/'.$item['image']) : 'https://placehold.co/80x84/f2c3ce/7a3c4d?text='.urlencode($item['nom']) }}" alt="{{ $item['nom'] }}">
          <div class="cart-panel-item-info">
            <strong>{{ $item['nom'] }}</strong>
            <span>{{ $item['quantite'] }} &times; {{ number_format($item['prix'], 0, ',', ' ') }} FCFA</span>
          </div>
          <form action="{{ route('panier.retirer', $id) }}" method="POST" class="cart-panel-remove-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="cart-panel-remove" aria-label="Retirer {{ $item['nom'] }} du panier">
              <svg width="14" height="14" class="icon"><use href="#icon-close"></use></svg>
            </button>
          </form>
        </li>
      @endforeach
    </ul>
    <div class="cart-panel-total" @if(empty($panier)) hidden @endif data-cart-total-row>
      <span>Total</span>
      <strong data-cart-total>{{ number_format(collect($panier)->sum(fn($i) => $i['prix'] * $i['quantite']), 0, ',', ' ') }} FCFA</strong>
    </div>
    <a href="{{ route('panier') }}" class="btn-primary-brand cart-panel-cta" @if(empty($panier)) hidden @endif data-cart-cta>Voir mon panier</a>
  </div>
</div>

<main>
@yield('content')
</main>

<footer class="site-footer" id="contact-footer">
  <div class="container-xl px-3 px-lg-4">
    <div class="footer-top">
      <div class="footer-brand">
        <a href="{{ route('boutique') }}" class="logo">
          <img src="{{ asset('lpdc-logo0.png') }}" alt="Le Plan Des Copines" class="logo-img">
        </a>
        <p>Votre destination mode &amp; beauté pour révéler la femme qui est en vous.</p>
        <div class="social-row">
          <a href="#" aria-label="Facebook"><svg width="16" height="16" class="icon"><use href="#icon-facebook"></use></svg></a>
          <a href="#" aria-label="Instagram"><svg width="16" height="16" class="icon"><use href="#icon-instagram"></use></svg></a>
          <a href="#" aria-label="TikTok"><svg width="16" height="16" class="icon"><use href="#icon-tiktok"></use></svg></a>
          <a href="#" aria-label="WhatsApp"><svg width="16" height="16" class="icon"><use href="#icon-whatsapp"></use></svg></a>
        </div>
      </div>

      <div class="footer-col">
        <h4>Boutique</h4>
        <ul>
          @foreach($categories ?? [] as $cat)
            <li><a href="{{ route('boutique.categorie', $cat->id) }}">{{ $cat->nom }}</a></li>
          @endforeach
          <li><a href="{{ route('boutique.produits') }}">Promotions</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Infos utiles</h4>
        <ul>
          <li><a href="{{ route('a-propos') }}">À propos</a></li>
          <li><a href="#">Livraison &amp; Retours</a></li>
          <li><a href="#">Conditions générales</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>
      </div>

      <div class="footer-col footer-account">
        <h4>Mon compte</h4>
        <ul>
          @auth
            <li><a href="{{ route('commande.mes-commandes') }}">Mes commandes</a></li>
            <li><a href="{{ route('panier') }}">Mon panier</a></li>
          @else
            <li><a href="{{ route('login') }}">Connexion</a></li>
            <li><a href="{{ route('register') }}">Créer un compte</a></li>
          @endauth
        </ul>
      </div>

      <div class="footer-col">
        <h4>Contact</h4>
        <ul class="footer-contact">
          <li>
            <svg width="15" height="15" class="icon"><use href="#icon-phone"></use></svg>
            <a href="tel:+22507000000">+225 07 00 00 00 00</a>
          </li>
          <li>
            <svg width="15" height="15" class="icon"><use href="#icon-mail"></use></svg>
            <a href="mailto:contact@leplandescopines.ci">contact@leplandescopines.ci</a>
          </li>
          <li>
            <svg width="15" height="15" class="icon"><use href="#icon-pin"></use></svg>
            <span>Abidjan, Côte d'Ivoire</span>
          </li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; {{ date('Y') }} Le Plan Des Copines. Tous droits réservés.</p>
      <div class="payment-icons">
        <svg width="40" height="24" class="icon"><use href="#icon-visa"></use></svg>
        <svg width="40" height="24" class="icon"><use href="#icon-mastercard"></use></svg>
        <svg width="40" height="24" class="icon"><use href="#icon-paypal"></use></svg>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
