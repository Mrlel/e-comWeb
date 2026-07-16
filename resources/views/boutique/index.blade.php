@extends('layouts.app')

@section('title', 'Accueil')
@section('page', 'accueil')

@section('content')

<!-- ============================================================ -->
<!-- HERO                                                           -->
<!-- ============================================================ -->
<section class="hero" aria-label="Mise en avant de la nouvelle collection">
  <div class="hero-shape hero-shape--1" aria-hidden="true"></div>
  <div class="hero-shape hero-shape--2" aria-hidden="true"></div>

  <div class="hero-slider" data-hero-slider>

    <article class="hero-slide is-active" data-hero-image="1">
      <div class="container-xl px-3 px-lg-4">
        <div class="hero-grid">
          <div class="hero-copy" data-animate>
            <p class="eyebrow">Nouvelle collection</p>
            <h1 class="hero-title">Affirmez votre style,<em>Rayonnez votre féminité.</em></h1>
            <p class="hero-subtitle">Des pièces sélectionnées avec soin pour des femmes uniques comme vous.</p>
            <div class="hero-actions">
              <a href="#produits" class="btn-primary-brand">
                Découvrir la collection
                <svg width="16" height="16" class="icon"><use href="#icon-chevron-right"></use></svg>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="hero-badge"><strong>-30%</strong><span>Sur une sélection</span></div>
    </article>

    <article class="hero-slide" data-hero-image="2">
      <div class="container-xl px-3 px-lg-4">
        <div class="hero-grid">
          <div class="hero-copy" data-animate>
            <p class="eyebrow">Édition limitée</p>
            <h1 class="hero-title">L'élégance,<em>en toute simplicité.</em></h1>
            <p class="hero-subtitle">Des matières douces et des coupes intemporelles pensées pour vous accompagner toute l'année.</p>
            <div class="hero-actions">
              <a href="#produits" class="btn-primary-brand">
                Voir la sélection
                <svg width="16" height="16" class="icon"><use href="#icon-chevron-right"></use></svg>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="hero-badge"><strong>Neuf</strong><span>Pièces exclusives</span></div>
    </article>

    <article class="hero-slide" data-hero-image="3">
      <div class="container-xl px-3 px-lg-4">
        <div class="hero-grid">
          <div class="hero-copy" data-animate>
            <p class="eyebrow">Tendance du moment</p>
            <h1 class="hero-title">Chaque pas,<em>une signature.</em></h1>
            <p class="hero-subtitle">Talons fins et sneakers chics : trouvez la paire qui vous ressemble.</p>
            <div class="hero-actions">
              <a href="#produits" class="btn-primary-brand">
                Explorer les chaussures
                <svg width="16" height="16" class="icon"><use href="#icon-chevron-right"></use></svg>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="hero-badge"><strong>-20%</strong><span>Chaussures</span></div>
    </article>

  </div>

  <div class="hero-controls">
    <button class="hero-arrow" type="button" data-hero-prev aria-label="Diapositive précédente">
      <svg width="15" height="15" class="icon"><use href="#icon-chevron-left"></use></svg>
    </button>
    <div class="hero-dots" data-hero-dots></div>
    <button class="hero-arrow" type="button" data-hero-next aria-label="Diapositive suivante">
      <svg width="15" height="15" class="icon"><use href="#icon-chevron-right"></use></svg>
    </button>
  </div>
</section>

<!-- ============================================================ -->
<!-- BANDE DE CONFIANCE                                             -->
<!-- ============================================================ -->
<section class="trust-strip" aria-label="Nos engagements">
  <div class="container-xl px-3 px-lg-4">
    <div class="trust-strip-inner">
      <div class="trust-item">
        <svg width="20" height="20" class="icon"><use href="#icon-shield"></use></svg>
        <div><strong>Paiement sécurisé</strong><span>Transactions 100% sécurisées</span></div>
      </div>
      <span class="trust-divider" aria-hidden="true"></span>
      <div class="trust-item">
        <svg width="20" height="20" class="icon"><use href="#icon-truck"></use></svg>
        <div><strong>Livraison rapide</strong><span>Côte d'Ivoire en 1 à 3 jours</span></div>
      </div>
      <span class="trust-divider" aria-hidden="true"></span>
      <div class="trust-item">
        <svg width="20" height="20" class="icon"><use href="#icon-rotate"></use></svg>
        <div><strong>Retour facile</strong><span>7 jours pour changer d'avis</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- CATÉGORIES                                                     -->
<!-- ============================================================ -->
<section class="categories" id="categories">
  <div class="container-xl px-3 px-lg-4">
    <div class="section-heading" data-animate>
      <div>
        <p class="eyebrow">Explorer</p>
        <h2>Nos catégories</h2>
      </div>
      <a href="#produits" class="link-arrow">
        <span class="long">Voir tout</span>
        <svg width="15" height="15" class="icon"><use href="#icon-chevron-right"></use></svg>
      </a>
    </div>

    @if($categories->isEmpty())
      <p class="empty-state">Aucune catégorie disponible pour le moment.</p>
    @else
      <div class="categories-grid stagger">
        @foreach($categories as $categorie)
          <div class="category-card" data-animate style="--i:{{ $loop->index }}">
            <div class="category-media {{ !$categorie->image ? 'is-empty' : '' }}">
              @if($categorie->image)
                <img src="{{ asset('storage/'.$categorie->image) }}" alt="{{ $categorie->nom }}" loading="lazy">
              @else
                <span>{{ mb_substr($categorie->nom, 0, 1) }}</span>
              @endif
            </div>
            <h3>{{ $categorie->nom }}</h3>
            <a href="{{ route('boutique.categorie', $categorie->id) }}" class="link-arrow">Voir tout</a>
          </div>
        @endforeach

        <div class="category-card" data-animate style="--i:{{ $categories->count() }}">
          <div class="category-media is-dark"><span>New</span></div>
          <h3>Nouveautés</h3>
          <a href="#produits" class="link-arrow">Voir tout</a>
        </div>
      </div>
    @endif
  </div>
</section>

<!-- ============================================================ -->
<!-- BANNIÈRE PROMOTIONNELLE                                        -->
<!-- ============================================================ -->
<section class="promo-cta" aria-label="Offre spéciale">
  <div class="container-xl px-3 px-lg-4">
    <div class="promo-cta-inner" data-animate>
      <svg class="promo-cta-leaf" width="90" height="140" viewBox="0 0 90 140" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
        <path d="M45 5c20 25 20 105 0 130M45 5C25 30 25 110 45 135M20 30c10 4 20 12 25 22M70 30c-10 4-20 12-25 22M15 70c12 0 24 5 30 12M75 70c-12 0-24 5-30 12M20 105c10-2 20-8 25-16M70 105c-10-2-20-8-25-16"/>
      </svg>
      <div class="promo-cta-content">
        <p class="eyebrow">Offre limitée</p>
        <h2>Jusqu'à -30% sur la nouvelle collection</h2>
        <p>Profitez de réductions exclusives sur une sélection de pièces, pour un temps limité seulement.</p>
        <a href="{{ route('boutique') }}#produits" class="btn-rose">Découvrir les promotions</a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- PRODUITS POPULAIRES                                            -->
<!-- ============================================================ -->
<section class="products" id="produits">
  <div class="container-xl px-3 px-lg-4">
    <div class="section-heading" data-animate>
      <div>
        <p class="eyebrow">Sélection</p>
        <h2>Nos produits populaires</h2>
      </div>
      <a href="{{ route('boutique') }}#produits" class="link-arrow">
        <span class="long">Voir tout</span>
        <svg width="15" height="15" class="icon"><use href="#icon-chevron-right"></use></svg>
      </a>
    </div>

    @if($produits->isEmpty())
      <p class="empty-state">Aucun produit disponible pour le moment.</p>
    @else
      <div class="products-track-wrap" data-animate="zoom">
        <button class="products-nav-btn products-nav-btn--prev" type="button" data-products-prev aria-label="Produits précédents">
          <svg width="16" height="16" class="icon"><use href="#icon-chevron-left"></use></svg>
        </button>

        <div class="products-track" data-products-track>
          @foreach($produits as $produit)
            @php
              $noteMoy = $produit->avis->count() ? round($produit->avis->avg('note')) : 0;
              $estNouveau = $produit->created_at && $produit->created_at->gt(now()->subDays(14));
            @endphp
            <article class="product-card">
              <div class="product-media">
                @if($estNouveau)
                  <span class="product-badge">Nouveau</span>
                @endif
                <img src="{{ $produit->image ? asset('storage/'.$produit->image) : 'https://placehold.co/480x504/f2c3ce/7a3c4d?text='.urlencode($produit->nom) }}" alt="{{ $produit->nom }}" loading="lazy">
                <button class="product-quickadd" type="submit" form="quickadd-{{ $produit->id }}">
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
                  <button class="product-quickadd-btn" type="submit" form="quickadd-{{ $produit->id }}" aria-label="Ajouter {{ $produit->nom }} au panier">
                    <svg width="16" height="16" class="icon"><use href="#icon-bag"></use></svg>
                  </button>
                </div>
                <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST" id="quickadd-{{ $produit->id }}" class="product-quickadd-form">
                  @csrf
                </form>
              </div>
            </article>
          @endforeach
        </div>

        <button class="products-nav-btn products-nav-btn--next" type="button" data-products-next aria-label="Produits suivants">
          <svg width="16" height="16" class="icon"><use href="#icon-chevron-right"></use></svg>
        </button>
      </div>
    @endif
  </div>
</section>

<!-- ============================================================ -->
<!-- TÉMOIGNAGES                                                    -->
<!-- ============================================================ -->
<section class="testimonials" id="a-propos">
  <div class="container-xl px-3 px-lg-4">
    <div class="section-heading justify-content-center text-center" data-animate>
      <div class="w-100">
        <p class="eyebrow justify-content-center">Confiance</p>
        <h2>Elles nous font confiance</h2>
        <div class="underline mx-auto"></div>
      </div>
    </div>

    <div class="testimonial-track-wrap">
      <div class="testimonial-track">

        <div class="testimonial-card" data-animate style="--i:0">
          <svg width="26" height="26" class="testimonial-quote"><use href="#icon-quote"></use></svg>
          <p class="comment">J'adore la qualité des produits et le service client est vraiment au top !</p>
          <div class="testimonial-stars">
            <svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg>
          </div>
          <div class="testimonial-author">
            <img src="https://placehold.co/92x92/f2c3ce/7a3c4d?text=A" alt="" loading="lazy">
            <div><strong>Aïcha K.</strong><span>Cliente vérifiée</span></div>
          </div>
        </div>

        <div class="testimonial-card" data-animate style="--i:1">
          <svg width="26" height="26" class="testimonial-quote"><use href="#icon-quote"></use></svg>
          <p class="comment">Ma boutique préférée ! Livraison rapide et articles conformes aux photos.</p>
          <div class="testimonial-stars">
            <svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg>
          </div>
          <div class="testimonial-author">
            <img src="https://placehold.co/92x92/f6dee3/7a3c4d?text=M" alt="" loading="lazy">
            <div><strong>Mariam T.</strong><span>Cliente vérifiée</span></div>
          </div>
        </div>

        <div class="testimonial-card" data-animate style="--i:2">
          <svg width="26" height="26" class="testimonial-quote"><use href="#icon-quote"></use></svg>
          <p class="comment">Des pépites à chaque commande. Je recommande à 100% !</p>
          <div class="testimonial-stars">
            <svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg>
          </div>
          <div class="testimonial-author">
            <img src="https://placehold.co/92x92/e4cd9c/6b4c1f?text=F" alt="" loading="lazy">
            <div><strong>Fatou D.</strong><span>Cliente vérifiée</span></div>
          </div>
        </div>

        <div class="testimonial-card" data-animate style="--i:0">
          <svg width="26" height="26" class="testimonial-quote"><use href="#icon-quote"></use></svg>
          <p class="comment">Un vrai coup de cœur pour le sac Élégance, la qualité est bluffante.</p>
          <div class="testimonial-stars">
            <svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg>
          </div>
          <div class="testimonial-author">
            <img src="https://placehold.co/92x92/f2c3ce/7a3c4d?text=S" alt="" loading="lazy">
            <div><strong>Sarah N.</strong><span>Cliente vérifiée</span></div>
          </div>
        </div>

        <div class="testimonial-card" data-animate style="--i:1">
          <svg width="26" height="26" class="testimonial-quote"><use href="#icon-quote"></use></svg>
          <p class="comment">Le service après-vente a été très réactif pour un échange de taille.</p>
          <div class="testimonial-stars">
            <svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg>
          </div>
          <div class="testimonial-author">
            <img src="https://placehold.co/92x92/f6dee3/7a3c4d?text=R" alt="" loading="lazy">
            <div><strong>Ramata S.</strong><span>Cliente vérifiée</span></div>
          </div>
        </div>

        <div class="testimonial-card" data-animate style="--i:2">
          <svg width="26" height="26" class="testimonial-quote"><use href="#icon-quote"></use></svg>
          <p class="comment">Emballage soigné, parfum délicat : une expérience premium du début à la fin.</p>
          <div class="testimonial-stars">
            <svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg><svg width="13" height="13"><use href="#icon-star"></use></svg>
          </div>
          <div class="testimonial-author">
            <img src="https://placehold.co/92x92/e4cd9c/6b4c1f?text=N" alt="" loading="lazy">
            <div><strong>Nadège A.</strong><span>Cliente vérifiée</span></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- NEWSLETTER                                                     -->
<!-- ============================================================ -->
<section class="newsletter" id="nouveautes">
  <div class="container-xl px-3 px-lg-4">
    <div class="newsletter-inner" data-animate>
      <p class="eyebrow justify-content-center">Restons connectées</p>
      <h2>Ne manquez aucune nouveauté</h2>
      <p>Inscrivez-vous à notre newsletter et recevez en avant-première nos nouvelles collections et offres exclusives.</p>
      <form class="newsletter-form" data-newsletter-form onsubmit="return false;">
        <label for="newsletter-email" class="visually-hidden">Adresse e-mail</label>
        <input type="email" id="newsletter-email" placeholder="Votre adresse e-mail" required>
        <button type="submit" class="btn-rose">S'inscrire</button>
      </form>
      <p class="newsletter-msg" data-newsletter-msg aria-live="polite"></p>
    </div>
  </div>
</section>

@endsection
