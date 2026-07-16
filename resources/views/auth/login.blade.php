@extends('layouts.app')

@section('title', 'Connexion')

@push('styles')
<style>
    .login-page { padding: 80px 0; }
    .login-card {
        max-width: 440px; margin: 0 auto; border: 1px solid #e3e3e3; border-radius: 6px;
        padding: 40px;
    }
    .login-card h1 { font-family: "Amatic SC", cursive; font-size: 42px; text-align: center; margin-bottom: 5px; }
    .login-card > p { text-align: center; color: #7b7b7b; margin-bottom: 30px; }
    .login-field { margin-bottom: 18px; }
    .login-field label { display: block; font-size: 13px; font-weight: 600; color: #1e1e1e; margin-bottom: 6px; }
    .login-field input[type="email"],
    .login-field input[type="password"] {
        width: 100%; padding: 12px 15px; border: 1px solid #e1e1e1; border-radius: 3px; font-size: 14px;
    }
    .login-remember { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #7b7b7b; margin-bottom: 22px; }
    .login-card button.primary-btn { border: none; cursor: pointer; width: 100%; text-align: center; }
    .error-msg { background: #fdecea; color: #c0392b; padding: 10px 15px; border-radius: 3px; font-size: 13px; margin-bottom: 18px; }
</style>
@endpush

@section('content')

<!-- Page Add Section Begin -->
<section class="page-add">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="page-breadcrumb">
                    <h2>Connexion<span>.</span></h2>
                    <a href="{{ route('boutique') }}">Accueil</a>
                    <a class="active" href="#">Connexion</a>
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
            <h1>Se connecter</h1>
            <p>Accédez à votre compte pour suivre vos commandes.</p>

            @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="login-field">
                    <label>Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="vous@exemple.com">
                </div>
                <div class="login-field">
                    <label>Mot de passe</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <label class="login-remember">
                    <input type="checkbox" name="remember"> Se souvenir de moi
                </label>
                <button type="submit" class="primary-btn">Se connecter</button>
            </form>

            <p style="text-align:center; margin:20px 0 0; font-size:13px; color:#7b7b7b;">
                Pas encore de compte ? <a href="{{ route('register') }}" style="color:#1e1e1e; font-weight:600;">Créer un compte</a>
            </p>
        </div>
    </div>
</div>

@endsection
