<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\CommandeController as AdminCommandeController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PageController;

Route::middleware(['auth'])->group(function () {
    // Paiement
    Route::prefix('paiement')->name('paiement.')->group(function () {
        Route::get('/commande/{commandeId}', [PaiementController::class, 'show'])->name('show');
        Route::post('/initier/{commandeId}', [PaiementController::class, 'initier'])->name('initier');
        Route::get('/retour', [PaiementController::class, 'retour'])->name('retour');
        Route::get('/echec/{commandeId}', [PaiementController::class, 'echec'])->name('echec');
    });

    // Espace client
    Route::get('/mes-commandes', [CommandeController::class, 'mesCommandes'])->name('commande.mes-commandes');
    Route::get('/mes-commandes/{id}', [CommandeController::class, 'detail'])->name('commande.detail');
});






// ─── AUTH ────────────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'loginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/inscription', [AuthController::class, 'registerForm'])->name('register')->middleware('guest');
Route::post('/inscription', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── BOUTIQUE ────────────────────────────────────────────────────────────────
Route::get('/', [BoutiqueController::class, 'index'])->name('boutique');
Route::get('/produit/{id}', [BoutiqueController::class, 'show'])->name('produit.show');
Route::get('/categorie/{id}', [BoutiqueController::class, 'categorie'])->name('boutique.categorie');

// ─── PANIER ──────────────────────────────────────────────────────────────────
Route::get('/panier', [PanierController::class, 'index'])->name('panier');
Route::post('/panier/ajouter/{id}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::delete('/panier/retirer/{id}', [PanierController::class, 'retirer'])->name('panier.retirer');
Route::delete('/panier/vider', [PanierController::class, 'vider'])->name('panier.vider');

// ─── COMMANDE ────────────────────────────────────────────────────────────────
Route::get('/commande/checkout', [CommandeController::class, 'checkout'])->name('commande.checkout');
Route::post('/commande/passer', [CommandeController::class, 'passer'])->name('commande.passer');

// ─── PAGES ───────────────────────────────────────────────────────────────────
Route::get('/a-propos', [PageController::class, 'about'])->name('a-propos');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');

// ─── ADMIN ───────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Produits
    Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
    Route::get('/produits/create', [ProduitController::class, 'create'])->name('produits.create');
    Route::post('/produits', [ProduitController::class, 'store'])->name('produits.store');
    Route::get('/produits/{id}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
    Route::put('/produits/{id}', [ProduitController::class, 'update'])->name('produits.update');
    Route::delete('/produits/{id}', [ProduitController::class, 'destroy'])->name('produits.destroy');

    // Catégories
    Route::get('/categories', [CategorieController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategorieController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategorieController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategorieController::class, 'destroy'])->name('categories.destroy');

    // Commandes
    Route::get('/commandes', [AdminCommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{id}', [AdminCommandeController::class, 'show'])->name('commandes.show');
    Route::patch('/commandes/{id}/statut', [AdminCommandeController::class, 'updateStatut'])->name('commandes.statut');

    // Utilisateurs
    Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->name('utilisateurs.index');
    Route::patch('/utilisateurs/{id}/toggle', [UtilisateurController::class, 'toggleRole'])->name('utilisateurs.toggle');
    Route::delete('/utilisateurs/{id}', [UtilisateurController::class, 'destroy'])->name('utilisateurs.destroy');
});
