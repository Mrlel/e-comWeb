import './bootstrap';

/**
 * LE PLAN DES COPINES — app.js
 * JavaScript vanilla, modulaire, sans dépendance jQuery.
 * Chaque section de la page est pilotée par un petit module autonome,
 * initialisé au chargement du DOM.
 */
(function () {
  'use strict';

  /* ----------------------------------------------------------------
   * Utilitaire : throttle par requestAnimationFrame
   * ---------------------------------------------------------------- */
  function rafThrottle(fn) {
    let ticking = false;
    return function (...args) {
      if (!ticking) {
        requestAnimationFrame(() => {
          fn.apply(this, args);
          ticking = false;
        });
        ticking = true;
      }
    };
  }

  /* ----------------------------------------------------------------
   * Module : Header sticky (ombre + compression au scroll)
   * ---------------------------------------------------------------- */
  function initStickyHeader() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    const onScroll = rafThrottle(() => {
      header.classList.toggle('is-scrolled', window.scrollY > 12);
    });
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ----------------------------------------------------------------
   * Module : Panier en AJAX (ajout & retrait, sans rechargement de page)
   * ---------------------------------------------------------------- */
  function formatFcfa(n) {
    return `${Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ')} FCFA`;
  }

  function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
  }

  function bumpCartBadges(newCount) {
    document.querySelectorAll('[data-cart-count]').forEach((badge) => {
      badge.textContent = String(newCount);
      badge.classList.remove('bump');
      void badge.offsetWidth; // force reflow pour rejouer l'animation
      badge.classList.add('bump');
    });
  }

  function updateCartPanelChrome(cartCount, cartTotal) {
    bumpCartBadges(cartCount);
    const title = document.querySelector('[data-cart-title]');
    if (title) title.textContent = `Mon panier (${cartCount})`;
    const totalEl = document.querySelector('[data-cart-total]');
    if (totalEl && cartTotal !== undefined) totalEl.textContent = formatFcfa(cartTotal);
  }

  function setCartPanelEmpty(isEmpty) {
    const panelBody = document.querySelector('[data-cart-panel-body]');
    if (!panelBody) return;
    panelBody.querySelector('[data-cart-list]')?.toggleAttribute('hidden', isEmpty);
    panelBody.querySelector('[data-cart-total-row]')?.toggleAttribute('hidden', isEmpty);
    panelBody.querySelector('[data-cart-cta]')?.toggleAttribute('hidden', isEmpty);
    panelBody.querySelector('[data-cart-empty]')?.toggleAttribute('hidden', !isEmpty);
  }

  function buildCartItemLi(item) {
    const li = document.createElement('li');
    li.className = 'cart-panel-item';
    li.setAttribute('data-cart-item', item.id);
    li.innerHTML = `
      <img src="${item.image ? '/storage/' + item.image : `https://placehold.co/80x84/f2c3ce/7a3c4d?text=${encodeURIComponent(item.nom)}`}" alt="${item.nom}">
      <div class="cart-panel-item-info">
        <strong></strong>
        <span class="cart-panel-item-qty"></span>
      </div>
      <form action="/panier/retirer/${item.id}" method="POST" class="cart-panel-remove-form">
        <input type="hidden" name="_token" value="${csrfToken()}">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="cart-panel-remove" aria-label="Retirer ${item.nom} du panier">
          <svg width="14" height="14" class="icon"><use href="#icon-close"></use></svg>
        </button>
      </form>
    `;
    li.querySelector('strong').textContent = item.nom;
    li.querySelector('.cart-panel-item-qty').textContent = `${item.quantite} × ${formatFcfa(item.prix)}`;
    return li;
  }

  function upsertCartPanelItem(item) {
    const list = document.querySelector('[data-cart-list]');
    if (!list) return;
    const existing = list.querySelector(`[data-cart-item="${item.id}"]`);
    if (existing) {
      existing.querySelector('.cart-panel-item-qty').textContent = `${item.quantite} × ${formatFcfa(item.prix)}`;
    } else {
      list.appendChild(buildCartItemLi(item));
    }
  }

  function initQuickAdd() {
    document.querySelectorAll('.product-quickadd-form').forEach((form) => {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        const buttons = form.id ? document.querySelectorAll(`[form="${form.id}"]`) : [];
        buttons.forEach((btn) => btn.classList.add('is-loading'));

        fetch(form.action, {
          method: 'POST',
          headers: { 'Accept': 'application/json' },
          body: new FormData(form),
        })
          .then((res) => res.json())
          .then((data) => {
            if (!data.success) return;
            updateCartPanelChrome(data.cartCount, data.cartTotal);
            if (data.item) upsertCartPanelItem(data.item);
            setCartPanelEmpty(false);
          })
          .catch(() => { form.submit(); })
          .finally(() => {
            buttons.forEach((btn) => btn.classList.remove('is-loading'));
          });
      });
    });
  }

  function initCartPanelRemove() {
    const panelBody = document.querySelector('[data-cart-panel-body]');
    if (!panelBody) return;

    panelBody.addEventListener('submit', (e) => {
      const form = e.target.closest('.cart-panel-remove-form');
      if (!form) return;
      e.preventDefault();

      const item = form.closest('[data-cart-item]');
      const btn = form.querySelector('.cart-panel-remove');
      btn?.classList.add('is-loading');

      fetch(form.action, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: new FormData(form),
      })
        .then((res) => res.json())
        .then((data) => {
          if (!data.success) return;
          item?.remove();
          updateCartPanelChrome(data.cartCount, data.cartTotal);
          if (data.isEmpty) setCartPanelEmpty(true);
        })
        .catch(() => { form.submit(); })
        .finally(() => { btn?.classList.remove('is-loading'); });
    });
  }

  /* ----------------------------------------------------------------
   * Module générique : Carrousel (utilisé par Hero et Témoignages)
   * options: { root, slideSelector, dotsRoot, prevBtn, nextBtn, interval }
   * ---------------------------------------------------------------- */
  function createCarousel({ root, slideSelector, dotsRoot, prevBtn, nextBtn, interval = 6000 }) {
    if (!root) return null;
    const slides = Array.from(root.querySelectorAll(slideSelector));
    if (!slides.length) return null;

    let index = 0;
    let timer = null;

    const dots = [];
    if (dotsRoot) {
      dotsRoot.innerHTML = '';
      slides.forEach((_, i) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'hero-dot';
        dot.setAttribute('aria-label', `Aller à l'élément ${i + 1}`);
        dot.addEventListener('click', () => goTo(i, true));
        dotsRoot.appendChild(dot);
        dots.push(dot);
      });
    }

    function render() {
      slides.forEach((s, i) => s.classList.toggle('is-active', i === index));
      dots.forEach((d, i) => d.classList.toggle('is-active', i === index));
    }

    function goTo(i, userTriggered) {
      index = (i + slides.length) % slides.length;
      render();
      if (userTriggered) restart();
    }

    function next() { goTo(index + 1); }
    function prev() { goTo(index - 1); }

    function start() {
      stop();
      timer = setInterval(next, interval);
    }
    function stop() { if (timer) clearInterval(timer); }
    function restart() { start(); }

    prevBtn?.addEventListener('click', () => goTo(index - 1, true));
    nextBtn?.addEventListener('click', () => goTo(index + 1, true));

    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);

    render();
    start();

    return { goTo, next, prev };
  }

  function initHeroSlider() {
    createCarousel({
      root: document.querySelector('[data-hero-slider]'),
      slideSelector: '.hero-slide',
      dotsRoot: document.querySelector('[data-hero-dots]'),
      prevBtn: document.querySelector('[data-hero-prev]'),
      nextBtn: document.querySelector('[data-hero-next]'),
      interval: 6500,
    });
  }

  /* ----------------------------------------------------------------
   * Module : Défilement horizontal des produits (boutons flèches)
   * ---------------------------------------------------------------- */
  function initProductsScroller() {
    const track = document.querySelector('[data-products-track]');
    const prevBtn = document.querySelector('[data-products-prev]');
    const nextBtn = document.querySelector('[data-products-next]');
    if (!track) return;

    const scrollByCard = (dir) => {
      const card = track.querySelector('.product-card');
      const gap = 24;
      const distance = card ? card.offsetWidth + gap : 260;
      track.scrollBy({ left: dir * distance, behavior: 'smooth' });
    };

    prevBtn?.addEventListener('click', () => scrollByCard(-1));
    nextBtn?.addEventListener('click', () => scrollByCard(1));
  }

  /* ----------------------------------------------------------------
   * Module : Apparition au scroll (IntersectionObserver)
   * ---------------------------------------------------------------- */
  function initScrollReveal() {
    const items = document.querySelectorAll('[data-animate]');
    if (!items.length) return;

    if (!('IntersectionObserver' in window)) {
      items.forEach((el) => el.classList.add('in-view'));
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('in-view');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    );

    items.forEach((el) => observer.observe(el));
  }

  /* ----------------------------------------------------------------
   * Module : Navigation active (navbar + bottom nav) selon data-page
   * ---------------------------------------------------------------- */
  function initActiveNav() {
    const current = document.body.getAttribute('data-page') || 'accueil';
    document.querySelectorAll('[data-nav-link]').forEach((link) => {
      link.classList.toggle('active', link.getAttribute('data-nav-link') === current);
    });
  }

  /* ----------------------------------------------------------------
   * Init global
   * ---------------------------------------------------------------- */
  document.addEventListener('DOMContentLoaded', () => {
    initStickyHeader();
    initQuickAdd();
    initCartPanelRemove();
    initHeroSlider();
    initProductsScroller();
    initScrollReveal();
    initActiveNav();
  });
})();
