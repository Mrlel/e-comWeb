@extends('layouts.app')

@section('title', 'Connexion')
@section('page', 'compte')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">Mon compte</p>
    <h1>Connexion</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      <span class="current">Connexion</span>
    </div>
  </div>
</section>

<section class="auth-section">
  <div class="container-xl px-3 px-lg-4">
    <div class="auth-card">
      <h1>Se connecter</h1>
      <p class="auth-sub">Accédez à votre compte pour suivre vos commandes.</p>

      @if($errors->any())
        <div class="form-alert error">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-field">
          <label for="email">Adresse e-mail</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="vous@exemple.com">
        </div>
        <div class="form-field">
          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>
        <label class="auth-remember">
          <input type="checkbox" name="remember"> Se souvenir de moi
        </label>
        <button type="submit" class="btn-primary-brand">Se connecter</button>
      </form>

      <p class="auth-switch">
        Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a>
      </p>
    </div>
  </div>
</section>

@endsection
