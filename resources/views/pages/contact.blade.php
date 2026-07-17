@extends('layouts.app')

@section('title', 'Contact')
@section('page', 'contact')

@section('content')

<section class="page-banner">
  <div class="container-xl px-3 px-lg-4">
    <p class="eyebrow">Nous écrire</p>
    <h1>Contactez-nous</h1>
    <div class="page-banner-crumb">
      <a href="{{ route('boutique') }}">Accueil</a>
      <span class="sep">/</span>
      <span class="current">Contact</span>
    </div>
  </div>
</section>

<section class="contact-section">
  <div class="container-xl px-3 px-lg-4">
    <div class="contact-grid">
      <div>
        <p class="eyebrow">Restons en contact</p>
        <h2 style="margin-bottom: 1.4rem;">Une question ? Écrivez-nous</h2>

        <div class="contact-info-list">
          <div class="contact-info-item">
            <div class="icon-circle"><svg width="18" height="18" class="icon"><use href="#icon-phone"></use></svg></div>
            <div>
              <strong>Téléphone</strong>
              <a href="tel:+22507000000">+225 07 00 00 00 00</a>
            </div>
          </div>
          <div class="contact-info-item">
            <div class="icon-circle"><svg width="18" height="18" class="icon"><use href="#icon-mail"></use></svg></div>
            <div>
              <strong>E-mail</strong>
              <a href="mailto:contact@leplandescopines.ci">contact@leplandescopines.ci</a>
            </div>
          </div>
          <div class="contact-info-item">
            <div class="icon-circle"><svg width="18" height="18" class="icon"><use href="#icon-pin"></use></svg></div>
            <div>
              <strong>Adresse</strong>
              <span>Abidjan, Côte d'Ivoire</span>
            </div>
          </div>
        </div>

        <div class="social-row">
          <a href="#" aria-label="Facebook"><svg width="16" height="16" class="icon"><use href="#icon-facebook"></use></svg></a>
          <a href="#" aria-label="Instagram"><svg width="16" height="16" class="icon"><use href="#icon-instagram"></use></svg></a>
          <a href="#" aria-label="TikTok"><svg width="16" height="16" class="icon"><use href="#icon-tiktok"></use></svg></a>
          <a href="#" aria-label="WhatsApp"><svg width="16" height="16" class="icon"><use href="#icon-whatsapp"></use></svg></a>
        </div>
      </div>

      <div class="contact-form-card">
        @if(session('success'))
          <div class="form-alert success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="form-alert error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('contact.send') }}" method="POST">
          @csrf
          <div class="form-field">
            <label for="nom">Nom complet</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required>
            @error('nom')<div class="form-error-msg">{{ $message }}</div>@enderror
          </div>
          <div class="form-field">
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')<div class="form-error-msg">{{ $message }}</div>@enderror
          </div>
          <div class="form-field">
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="Votre message…" required>{{ old('message') }}</textarea>
            @error('message')<div class="form-error-msg">{{ $message }}</div>@enderror
          </div>
          <button type="submit" class="btn-rose" style="width:100%; justify-content:center;">Envoyer le message</button>
        </form>
      </div>
    </div>
  </div>
</section>

@endsection
