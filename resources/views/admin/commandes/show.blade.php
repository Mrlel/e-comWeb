@extends('admin.layouts.app')

@section('title', 'Commande ' . $commande->reference_commande)

@push('styles')
<style>
    .detail-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }
    .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f5f5f5; font-size: 0.9em; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #888; }
    .info-value { font-weight: 600; color: #1a1a2e; }
    @media(max-width:800px) { .detail-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div style="margin-bottom:20px">
    <a href="{{ route('admin.commandes.index') }}" class="btn btn-primary btn-sm">← Retour aux commandes</a>
</div>

<div class="detail-grid">
    <div>
        <!-- PRODUITS -->
        <div class="card" style="margin-bottom:20px">
            <div class="card-header"><h2>📦 Produits commandés</h2></div>
            <table class="table">
                <thead>
                    <tr><th>Produit</th><th>Prix unit.</th><th>Qté</th><th>Sous-total</th></tr>
                </thead>
                <tbody>
                    @foreach($commande->ligneCommandes as $ligne)
                    <tr>
                        <td><strong>{{ $ligne->produit->nom ?? 'Produit supprimé' }}</strong></td>
                        <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                        <td>{{ $ligne->quantite }}</td>
                        <td style="font-weight:700; color:#10b981">{{ number_format($ligne->sous_total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right; font-weight:700; padding:13px 15px">Total</td>
                        <td style="font-weight:700; font-size:1.1em; color:#10b981; padding:13px 15px">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- PAIEMENT -->
        @if($commande->paiement)
        <div class="card">
            <div class="card-header"><h2>💳 Informations de paiement</h2></div>
            <div class="card-body">
                <div class="info-row"><span class="info-label">Référence paiement</span><span class="info-value">{{ $commande->paiement->reference_paiement }}</span></div>
                <div class="info-row"><span class="info-label">Transaction ID</span><span class="info-value">{{ $commande->paiement->transaction_id ?? '—' }}</span></div>
                <div class="info-row"><span class="info-label">Méthode</span><span class="info-value">{{ $commande->paiement->methode }}</span></div>
                <div class="info-row"><span class="info-label">Provider</span><span class="info-value">{{ $commande->paiement->provider }}</span></div>
                <div class="info-row">
                    <span class="info-label">Statut</span>
                    <span class="badge {{ $commande->paiement->statut === 'réussi' ? 'badge-success' : 'badge-danger' }}">
                        {{ $commande->paiement->statut }}
                    </span>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div>
        <!-- INFOS COMMANDE -->
        <div class="card" style="margin-bottom:20px">
            <div class="card-header"><h2>🧾 Détails commande</h2></div>
            <div class="card-body">
                <div class="info-row"><span class="info-label">Référence</span><span class="info-value">{{ $commande->reference_commande }}</span></div>
                <div class="info-row"><span class="info-label">Date</span><span class="info-value">{{ $commande->created_at->format('d/m/Y H:i') }}</span></div>
                <div class="info-row">
                    <span class="info-label">Statut</span>
                    @if($commande->statut === 'payé')
                        <span class="badge badge-success">✅ Payé</span>
                    @elseif($commande->statut === 'en_attente')
                        <span class="badge badge-warning">⏳ En attente</span>
                    @else
                        <span class="badge badge-danger">❌ Annulé</span>
                    @endif
                </div>
                <div class="info-row"><span class="info-label">Adresse</span><span class="info-value" style="text-align:right; max-width:180px">{{ $commande->adresse_livraison }}</span></div>
            </div>
        </div>

        <!-- CLIENT -->
        <div class="card" style="margin-bottom:20px">
            <div class="card-header"><h2>👤 Client</h2></div>
            <div class="card-body">
                <div class="info-row"><span class="info-label">Nom</span><span class="info-value">{{ $commande->user->prenom }} {{ $commande->user->nom }}</span></div>
                <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $commande->user->email }}</span></div>
                <div class="info-row"><span class="info-label">Téléphone</span><span class="info-value">{{ $commande->user->telephone ?? '—' }}</span></div>
            </div>
        </div>

        <!-- CHANGER STATUT -->
        <div class="card">
            <div class="card-header"><h2>⚙️ Changer le statut</h2></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.commandes.statut', $commande->id) }}">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <select name="statut" class="form-control">
                            <option value="en_attente" {{ $commande->statut === 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                            <option value="payé"       {{ $commande->statut === 'payé'       ? 'selected' : '' }}>✅ Payé</option>
                            <option value="annulé"     {{ $commande->statut === 'annulé'     ? 'selected' : '' }}>❌ Annulé</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning" style="width:100%">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
