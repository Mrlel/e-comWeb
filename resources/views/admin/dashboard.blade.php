@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 25px; }
    .stat-card {
        background: white; border-radius: 14px; padding: 22px 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 18px;
    }
    .stat-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5em; flex-shrink: 0; }
    .stat-icon.purple { background: #ede9fe; }
    .stat-icon.green  { background: #d1fae5; }
    .stat-icon.blue   { background: #dbeafe; }
    .stat-icon.orange { background: #fef3c7; }
    .stat-icon.red    { background: #fee2e2; }
    .stat-icon.teal   { background: #ccfbf1; }
    .stat-value { font-size: 1.8em; font-weight: 700; color: #1a1a2e; line-height: 1; }
    .stat-label { font-size: 0.82em; color: #888; margin-top: 4px; }

    .dashboard-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }

    .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
    .dot-green  { background: #10b981; }
    .dot-yellow { background: #f59e0b; }
    .dot-red    { background: #ef4444; }

    @media(max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .dashboard-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<!-- STATS -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple">🧾</div>
        <div>
            <div class="stat-value">{{ $stats['total_commandes'] }}</div>
            <div class="stat-label">Total commandes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div>
            <div class="stat-value">{{ $stats['commandes_payees'] }}</div>
            <div class="stat-label">Commandes payées</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal">💰</div>
        <div>
            <div class="stat-value">{{ number_format($stats['chiffre_affaires'], 0, ',', ' ') }}</div>
            <div class="stat-label">Chiffre d'affaires (FCFA)</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">📦</div>
        <div>
            <div class="stat-value">{{ $stats['total_produits'] }}</div>
            <div class="stat-label">Produits</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">👥</div>
        <div>
            <div class="stat-value">{{ $stats['total_clients'] }}</div>
            <div class="stat-label">Clients</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">⚠️</div>
        <div>
            <div class="stat-value">{{ $stats['stock_faible'] }}</div>
            <div class="stat-label">Produits stock faible</div>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- DERNIÈRES COMMANDES -->
    <div class="card">
        <div class="card-header">
            <h2>🧾 Dernières commandes</h2>
            <a href="{{ route('admin.commandes.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Client</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($dernieres_commandes as $cmd)
                <tr>
                    <td><strong>{{ $cmd->reference_commande }}</strong></td>
                    <td>{{ $cmd->user->prenom ?? '—' }} {{ $cmd->user->nom ?? '' }}</td>
                    <td>{{ number_format($cmd->montant_total, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($cmd->statut === 'payé')
                            <span class="badge badge-success">✅ Payé</span>
                        @elseif($cmd->statut === 'en_attente')
                            <span class="badge badge-warning">⏳ En attente</span>
                        @else
                            <span class="badge badge-danger">❌ Annulé</span>
                        @endif
                    </td>
                    <td><a href="{{ route('admin.commandes.show', $cmd->id) }}" class="btn btn-sm btn-primary">Voir</a></td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; color:#888; padding:30px">Aucune commande</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PRODUITS POPULAIRES -->
    <div class="card">
        <div class="card-header">
            <h2>🔥 Top produits</h2>
        </div>
        <div class="card-body" style="padding:15px">
            @forelse($produits_populaires as $i => $p)
            <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f5f5f5">
                <div style="width:28px; height:28px; background:#667eea; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:0.8em; font-weight:700; flex-shrink:0">{{ $i+1 }}</div>
                <div style="flex:1">
                    <div style="font-size:0.9em; font-weight:600; color:#1a1a2e">{{ $p->nom }}</div>
                    <div style="font-size:0.78em; color:#888">{{ $p->ligne_commandes_count }} vente(s)</div>
                </div>
                <div style="font-size:0.85em; font-weight:700; color:#10b981">{{ number_format($p->prix, 0, ',', ' ') }}</div>
            </div>
            @empty
            <p style="text-align:center; color:#888; padding:20px">Aucune donnée</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
