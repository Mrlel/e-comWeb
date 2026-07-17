@extends('layouts.app')

@section('title', 'À propos')
@section('page', 'a-propos')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">Notre histoire</p>
    <h1>À propos de nous</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      <span class="current">À propos</span>
    </div>
  </div>
</section>

<section class="about-section">
  <div class="container-xl px-3 px-lg-4">
    <div class="about-intro" data-animate>
      <p class="eyebrow" style="justify-content:center;">Le Plan Des Copines</p>
      <h2 style="margin-bottom: 1rem;">Votre destination mode &amp; beauté</h2>
      <p>
        Née à Abidjan, Le Plan Des Copines est bien plus qu'une boutique en ligne : c'est une invitation à révéler
        la femme qui est en vous. Nous sélectionnons avec soin des vêtements, chaussures, sacs, accessoires et
        produits de beauté qui allient élégance intemporelle et tendances du moment, pour que chaque cliente
        trouve la pièce qui lui ressemble.
      </p>
    </div>

    <div class="about-values-grid stagger">
      <div class="about-value-card" data-animate style="--i:0">
        <div class="advantage-icon"><svg width="22" height="22" class="icon"><use href="#icon-shield"></use></svg></div>
        <h3>Qualité premium</h3>
        <p>Chaque produit est sélectionné avec exigence pour vous garantir des pièces qui durent.</p>
      </div>
      <div class="about-value-card" data-animate style="--i:1">
        <div class="advantage-icon"><svg width="22" height="22" class="icon"><use href="#icon-heart"></use></svg></div>
        <h3>Passion &amp; proximité</h3>
        <p>Une équipe à l'écoute, disponible pour vous conseiller et vous accompagner à chaque étape.</p>
      </div>
      <div class="about-value-card" data-animate style="--i:2">
        <div class="advantage-icon"><svg width="22" height="22" class="icon"><use href="#icon-truck"></use></svg></div>
        <h3>Livraison fiable</h3>
        <p>Une logistique pensée pour vous livrer rapidement, partout en Côte d'Ivoire.</p>
      </div>
    </div>
  </div>
</section>

@endsection
