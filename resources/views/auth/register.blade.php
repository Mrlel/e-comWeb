@extends('layouts.app')

@section('title', 'Créer un compte')
@section('page', 'compte')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">Mon compte</p>
    <h1>Créer un compte</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      <span class="current">Inscription</span>
    </div>
  </div>
</section>

<section class="auth-section">
  <div class="container-xl px-3 px-lg-4">
    <div class="auth-card">
      <h1>Créer un compte</h1>
      <p class="auth-sub">Suivez vos commandes et gagnez du temps à chaque achat.</p>

      @if($errors->any())
        <div class="form-alert error">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-row-2">
          <div class="form-field">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required autofocus placeholder="Konan">
            @error('prenom')<div class="form-error-msg">{{ $message }}</div>@enderror
          </div>
          <div class="form-field">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required placeholder="Yao">
            @error('nom')<div class="form-error-msg">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="form-field">
          <label for="email">Adresse e-mail</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="vous@exemple.com">
          @error('email')<div class="form-error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-field">
          <label for="telephone">Téléphone <span style="font-weight:400; color:var(--text-soft);">(optionnel)</span></label>
          <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}" placeholder="+225 07 00 00 00 00">
          @error('telephone')<div class="form-error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-row-2">
          <div class="form-field">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required placeholder="8 caractères min.">
            @error('password')<div class="form-error-msg">{{ $message }}</div>@enderror
          </div>
          <div class="form-field">
            <label for="password_confirmation">Confirmer</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
          </div>
        </div>
        <button type="submit" class="btn-primary-brand">Créer mon compte</button>
      </form>

      <p class="auth-switch">
        Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
      </p>
    </div>
  </div>
</section>

@endsection
