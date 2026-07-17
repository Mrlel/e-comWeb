@extends('layouts.app')

@section('title', 'Mes commandes')
@section('page', 'compte')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">Mon compte</p>
    <h1>Mes commandes</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      <span class="current">Mes commandes</span>
    </div>
  </div>
</section>

<section class="cart-page">
  <div class="container-xl px-3 px-lg-4">
    @if($commandes->isEmpty())
      <div class="cart-empty">
        <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.4"><use href="#icon-bag"></use></svg>
        <p>Vous n'avez pas encore passé de commande.</p>
        <a href="{{ route('boutique') }}" class="btn-primary-brand">
          Découvrir la boutique
          <svg width="16" height="16" class="icon"><use href="#icon-chevron-right"></use></svg>
        </a>
      </div>
    @else
      <div class="orders-table-wrap">
        <table class="orders-table">
          <thead>
            <tr>
              <th>Référence</th>
              <th>Date</th>
              <th>Articles</th>
              <th>Montant</th>
              <th>Statut</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($commandes as $commande)
              <tr>
                <td><strong>{{ $commande->reference_commande }}</strong></td>
                <td>{{ $commande->created_at->format('d/m/Y') }}</td>
                <td>{{ $commande->ligneCommandes->sum('quantite') }} article(s)</td>
                <td>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                <td><span class="order-status {{ $commande->statut }}">{{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</span></td>
                <td><a href="{{ route('commande.detail', $commande->id) }}" class="link-arrow">Détails <svg width="14" height="14" class="icon"><use href="#icon-chevron-right"></use></svg></a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</section>

@endsection
