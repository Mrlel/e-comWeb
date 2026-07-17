@extends('layouts.app')

@section('title', $produit->nom)
@section('page', 'produits')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">{{ $produit->categorie->nom ?? 'Boutique' }}</p>
    <h1>{{ $produit->nom }}</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      @if($produit->categorie)
        <a href="{{ route('boutique.categorie', $produit->categorie->id) }}">{{ $produit->categorie->nom }}</a>
        <span class="sep">/</span>
      @endif
      <span class="current">{{ $produit->nom }}</span>
    </div>
  </div>
</section>

<section class="product-detail">
  <div class="container-xl px-3 px-lg-4">
    @php
      $noteMoy = $produit->avis->count() ? round($produit->avis->avg('note')) : 0;
      $enStock = $produit->stock > 0;
    @endphp
    <div class="product-detail-grid">
      <div class="product-detail-media">
        <img src="{{ $produit->image ? asset('storage/'.$produit->image) : 'https://placehold.co/800x840/f2c3ce/7a3c4d?text='.urlencode($produit->nom) }}" alt="{{ $produit->nom }}">
      </div>

      <div class="product-detail-info">
        @if($produit->categorie)
          <a href="{{ route('boutique.categorie', $produit->categorie->id) }}" class="link-arrow product-detail-category">{{ $produit->categorie->nom }}</a>
        @endif
        <h1>{{ $produit->nom }}</h1>

        @if($produit->avis->count())
          <div class="product-rating">
            <span class="stars">
              @for($i = 1; $i <= 5; $i++)
                <svg width="14" height="14" style="{{ $i > $noteMoy ? 'opacity:.3' : '' }}"><use href="#icon-star"></use></svg>
              @endfor
            </span>
            <span>({{ $produit->avis->count() }} avis)</span>
          </div>
        @endif

        <div class="product-detail-price">
          <span class="current">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
        </div>

        <p class="product-detail-desc">{{ $produit->description ?: "Aucune description n'est disponible pour ce produit." }}</p>

        <div class="product-detail-meta {{ $enStock ? '' : 'is-out' }}">
          <span class="dot"></span>
          @if($enStock)
            <span>En stock — {{ $produit->stock }} disponible(s)</span>
          @else
            <span>Rupture de stock</span>
          @endif
        </div>

        @if($enStock)
          <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST" class="product-quickadd-form" id="detail-add-{{ $produit->id }}">
            @csrf
            <div class="product-detail-actions">
              <div class="qty-stepper">
                <button type="button" data-qty-minus aria-label="Diminuer la quantité">&minus;</button>
                <input type="number" name="quantite" value="1" min="1" max="{{ $produit->stock }}" aria-label="Quantité">
                <button type="button" data-qty-plus aria-label="Augmenter la quantité">+</button>
              </div>
              <button type="submit" class="btn-primary-brand">
                <svg width="16" height="16" class="icon"><use href="#icon-bag"></use></svg>
                Ajouter au panier
              </button>
            </div>
          </form>
        @endif
      </div>
    </div>
  </div>
</section>

<section class="reviews-section">
  <div class="container-xl px-3 px-lg-4">
    <div class="section-heading" data-animate>
      <div>
        <p class="eyebrow">Avis clients</p>
        <h2>Ce qu'elles en pensent</h2>
      </div>
    </div>

    @if($produit->avis->isEmpty())
      <p class="no-reviews">Aucun avis pour le moment. Soyez la première à donner votre avis !</p>
    @else
      <div class="reviews-list">
        @foreach($produit->avis as $avis)
          <div class="review-card">
            <div class="stars">
              @for($i = 1; $i <= 5; $i++)
                <svg width="13" height="13" style="{{ $i > $avis->note ? 'opacity:.3' : '' }}"><use href="#icon-star"></use></svg>
              @endfor
            </div>
            <p class="comment">{{ $avis->commentaire }}</p>
            <p class="author">{{ $avis->user->prenom ?? 'Cliente' }} {{ $avis->user->nom ?? '' }}</p>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>

@if($produitsLies->isNotEmpty())
<section class="products" aria-label="Produits similaires">
  <div class="container-xl px-3 px-lg-4">
    <div class="section-heading" data-animate>
      <div>
        <p class="eyebrow">Vous aimerez aussi</p>
        <h2>Produits similaires</h2>
      </div>
    </div>

    <div class="products-track-wrap">
      <div class="products-track">
        @foreach($produitsLies as $lie)
          <article class="product-card">
            <div class="product-media">
              <img src="{{ $lie->image ? asset('storage/'.$lie->image) : 'https://placehold.co/480x504/f2c3ce/7a3c4d?text='.urlencode($lie->nom) }}" alt="{{ $lie->nom }}" loading="lazy">
            </div>
            <div class="product-body">
              <h3><a href="{{ route('produit.show', $lie->id) }}">{{ $lie->nom }}</a></h3>
              <div class="product-price-row">
                <div class="product-price"><span class="current">{{ number_format($lie->prix, 0, ',', ' ') }} FCFA</span></div>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

@endsection

@push('scripts')
<script>
  document.querySelectorAll('.qty-stepper').forEach((stepper) => {
    const input = stepper.querySelector('input');
    const max = parseInt(input.max || '99', 10);
    stepper.querySelector('[data-qty-minus]').addEventListener('click', () => {
      input.value = Math.max(1, (parseInt(input.value, 10) || 1) - 1);
    });
    stepper.querySelector('[data-qty-plus]').addEventListener('click', () => {
      input.value = Math.min(max, (parseInt(input.value, 10) || 1) + 1);
    });
  });
</script>
@endpush
