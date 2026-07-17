@extends('layouts.app')

@section('title', $categorie->nom)
@section('page', 'produits')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">Catégorie</p>
    <h1>{{ $categorie->nom }}</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      <span class="current">{{ $categorie->nom }}</span>
    </div>
  </div>
</section>

<section class="products" style="padding-top: clamp(2rem, 4vw, 3rem);">
  <div class="container-xl px-3 px-lg-4">
    @if($categories->isNotEmpty())
      <div class="categories-grid" style="margin-bottom: clamp(2rem, 4vw, 3rem);">
        @foreach($categories as $cat)
          <div class="category-card">
            <a href="{{ route('boutique.categorie', $cat->id) }}">
              <div class="category-media {{ !$cat->image ? 'is-empty' : '' }} {{ $cat->id === $categorie->id ? 'is-active-cat' : '' }}">
                @if($cat->image)
                  <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->nom }}" loading="lazy">
                @else
                  <span>{{ mb_substr($cat->nom, 0, 1) }}</span>
                @endif
              </div>
            </a>
            <h3>{{ $cat->nom }}</h3>
          </div>
        @endforeach
      </div>
    @endif

    <div class="section-heading" data-animate>
      <div>
        <p class="eyebrow">{{ $produits->total() }} produit(s)</p>
        <h2>{{ $categorie->nom }}</h2>
      </div>
    </div>

    @if($produits->isEmpty())
      <p class="empty-state">Aucun produit disponible dans cette catégorie pour le moment.</p>
    @else
      <div class="products-grid">
        @foreach($produits as $produit)
          @php
            $noteMoy = $produit->avis->count() ? round($produit->avis->avg('note')) : 0;
          @endphp
          <article class="product-card">
            <div class="product-media">
              <img src="{{ $produit->image ? asset('storage/'.$produit->image) : 'https://placehold.co/480x504/f2c3ce/7a3c4d?text='.urlencode($produit->nom) }}" alt="{{ $produit->nom }}" loading="lazy">
              <button class="product-quickadd" type="submit" form="quickadd-cat-{{ $produit->id }}">
                <svg width="15" height="15" class="icon"><use href="#icon-bag"></use></svg>
                Ajout rapide
              </button>
            </div>
            <div class="product-body">
              <h3><a href="{{ route('produit.show', $produit->id) }}">{{ $produit->nom }}</a></h3>
              @if($produit->avis->count())
                <div class="product-rating">
                  <span class="stars">
                    @for($i = 1; $i <= 5; $i++)
                      <svg width="12" height="12" style="{{ $i > $noteMoy ? 'opacity:.3' : '' }}"><use href="#icon-star"></use></svg>
                    @endfor
                  </span>
                  <span>({{ $produit->avis->count() }})</span>
                </div>
              @endif
              <div class="product-price-row">
                <div class="product-price"><span class="current">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span></div>
                <button class="product-quickadd-btn" type="submit" form="quickadd-cat-{{ $produit->id }}" aria-label="Ajouter {{ $produit->nom }} au panier">
                  <svg width="16" height="16" class="icon"><use href="#icon-bag"></use></svg>
                </button>
              </div>
              <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST" id="quickadd-cat-{{ $produit->id }}" class="product-quickadd-form">
                @csrf
              </form>
            </div>
          </article>
        @endforeach
      </div>

      {{ $produits->links() }}
    @endif
  </div>
</section>

@endsection
