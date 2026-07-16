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
   * Module : Recherche (flyout)
   * ---------------------------------------------------------------- */
  function initSearchFlyout() {
    const toggleBtn = document.querySelector('[data-search-toggle]');
    const flyout = document.querySelector('[data-search-flyout]');
    if (!toggleBtn || !flyout) return;

    const close = () => {
      flyout.classList.remove('is-open');
      toggleBtn.setAttribute('aria-expanded', 'false');
    };

    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = flyout.classList.toggle('is-open');
      toggleBtn.setAttribute('aria-expanded', String(isOpen));
      if (isOpen) flyout.querySelector('input')?.focus();
    });

    document.addEventListener('click', (e) => {
      if (!flyout.contains(e.target) && e.target !== toggleBtn) close();
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') close();
    });
  }

  /* ----------------------------------------------------------------
   * Module : Panier & Favoris (compteurs dynamiques, purement UI)
   * ---------------------------------------------------------------- */
  function initCartAndFavorites() {
    const cartBadges = document.querySelectorAll('[data-cart-count]');
    let cartCount = parseInt(cartBadges[0]?.textContent || '0', 10);

    function bumpCart() {
      cartCount += 1;
      cartBadges.forEach((badge) => {
        badge.textContent = String(cartCount);
        badge.classList.remove('bump');
        // force reflow pour rejouer l'animation
        void badge.offsetWidth;
        badge.classList.add('bump');
      });
    }

    document.querySelectorAll('[data-add-to-cart]').forEach((btn) => {
      btn.addEventListener('click', () => bumpCart());
    });

    const favBadges = document.querySelectorAll('[data-fav-count]');
    let favCount = parseInt(favBadges[0]?.textContent || '0', 10);

    document.querySelectorAll('[data-fav-toggle]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const nowActive = btn.classList.toggle('is-active');
        favCount += nowActive ? 1 : -1;
        favCount = Math.max(favCount, 0);
        favBadges.forEach((badge) => { badge.textContent = String(favCount); });
        btn.setAttribute('aria-pressed', String(nowActive));
      });
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

  function initTestimonialSlider() {
    const wrap = document.querySelector('[data-testimonial-slider]');
    const track = document.querySelector('[data-testimonial-track]');
    const dotsRoot = document.querySelector('[data-testimonial-dots]');
    if (!wrap || !track) return;

    const groups = Array.from(track.children);
    let index = 0;
    let timer = null;
    const dots = [];

    if (dotsRoot) {
      groups.forEach((_, i) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'hero-dot';
        dot.setAttribute('aria-label', `Groupe de témoignages ${i + 1}`);
        dot.addEventListener('click', () => goTo(i));
        dotsRoot.appendChild(dot);
        dots.push(dot);
      });
    }

    function render() {
      track.style.transform = `translateX(-${index * 100}%)`;
      dots.forEach((d, i) => d.classList.toggle('is-active', i === index));
    }
    function goTo(i) {
      index = (i + groups.length) % groups.length;
      render();
      restart();
    }
    function start() { stop(); timer = setInterval(() => goTo(index + 1), 7000); }
    function stop() { if (timer) clearInterval(timer); }
    function restart() { start(); }

    wrap.addEventListener('mouseenter', stop);
    wrap.addEventListener('mouseleave', start);

    render();
    start();
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
   * Module : Newsletter — validation JS simple
   * ---------------------------------------------------------------- */
  function initNewsletterForms() {
    document.querySelectorAll('[data-newsletter-form]').forEach((form) => {
      const input = form.querySelector('input[type="email"]');
      const msg = form.querySelector('[data-newsletter-msg]');

      form.addEventListener('submit', (e) => {
        e.preventDefault();
        const value = input.value.trim();
        const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

        input.classList.toggle('is-invalid', !isValid);

        if (!isValid) {
          if (msg) {
            msg.textContent = 'Merci de renseigner une adresse e-mail valide.';
            msg.className = 'newsletter-msg error';
          }
          input.focus();
          return;
        }

        if (msg) {
          msg.textContent = `Merci ! Vous recevrez nos prochaines offres à ${value}.`;
          msg.className = 'newsletter-msg success';
        }
        form.reset();
      });
    });
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
    initSearchFlyout();
    initCartAndFavorites();
    initHeroSlider();
    initTestimonialSlider();
    initProductsScroller();
    initNewsletterForms();
    initScrollReveal();
    initActiveNav();
  });
})();
