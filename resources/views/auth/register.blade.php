@extends('layouts.app')

@section('title', 'Créer un compte')

@push('styles')
<style>
    .login-page { padding: 80px 0; }
    .login-card {
        max-width: 480px; margin: 0 auto; border: 1px solid #e3e3e3; border-radius: 6px;
        padding: 40px;
    }
    .login-card h1 { font-family: "Amatic SC", cursive; font-size: 42px; text-align: center; margin-bottom: 5px; }
    .login-card > p.lede { text-align: center; color: #7b7b7b; margin-bottom: 30px; }
    .login-field { margin-bottom: 18px; }
    .login-field label { display: block; font-size: 13px; font-weight: 600; color: #1e1e1e; margin-bottom: 6px; }
    .login-field input {
        width: 100%; padding: 12px 15px; border: 1px solid #e1e1e1; border-radius: 3px; font-size: 14px;
    }
    .login-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .login-card button.primary-btn { border: none; cursor: pointer; width: 100%; text-align: center; }
    .error-msg { background: #fdecea; color: #c0392b; padding: 10px 15px; border-radius: 3px; font-size: 13px; margin-bottom: 18px; }
    .field-error { color: #c0392b; font-size: 12px; display: block; margin-top: 4px; }
</style>
@endpush

@section('content')

<!-- Page Add Section Begin -->
<section class="page-add">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="page-breadcrumb">
                    <h2>Inscription<span>.</span></h2>
                    <a href="{{ route('boutique') }}">Accueil</a>
                    <a class="active" href="#">Inscription</a>
                </div>
            </div>
            <div class="col-lg-8">
                <img src="{{ asset('template/img/add.jpg') }}" alt="">
            </div>
        </div>
    </div>
</section>
<!-- Page Add Section End -->

<div class="login-page">
    <div class="container">
        <div class="login-card">
            <h1>Créer un compte</h1>
            <p class="lede">Suivez vos commandes et gagnez du temps à chaque achat.</p>

            @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="login-row">
                    <div class="login-field">
                        <label>Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}" required autofocus placeholder="Konan">
                        @error('prenom')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="login-field">
                        <label>Nom</label>
                        <input type="text" name="nom" value="{{ old('nom') }}" required placeholder="Yao">
                        @error('nom')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="login-field">
                    <label>Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="vous@exemple.com">
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="login-field">
                    <label>Téléphone <span style="font-weight:400; color:#7b7b7b;">(optionnel)</span></label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="+225 07 00 00 00 00">
                    @error('telephone')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="login-row">
                    <div class="login-field">
                        <label>Mot de passe</label>
                        <input type="password" name="password" required placeholder="8 caractères min.">
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="login-field">
                        <label>Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="primary-btn">Créer mon compte</button>
            </form>

            <p style="text-align:center; margin:20px 0 0; font-size:13px; color:#7b7b7b;">
                Déjà un compte ? <a href="{{ route('login') }}" style="color:#1e1e1e; font-weight:600;">Se connecter</a>
            </p>
        </div>
    </div>
</div>

@endsection
