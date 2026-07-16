@extends('admin.layouts.app')

@section('title', 'Commandes')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>🧾 Commandes ({{ $commandes->total() }})</h2>
        <!-- Filtre statut -->
        <form method="GET" style="display:flex; gap:8px; align-items:center">
            <select name="statut" class="form-control" style="width:auto; padding:7px 12px">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                <option value="payé"       {{ request('statut') === 'payé'       ? 'selected' : '' }}>✅ Payé</option>
                <option value="annulé"     {{ request('statut') === 'annulé'     ? 'selected' : '' }}>❌ Annulé</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
            @if(request('statut'))
                <a href="{{ route('admin.commandes.index') }}" class="btn btn-sm btn-primary">✕ Reset</a>
            @endif
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Client</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Paiement</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($commandes as $cmd)
            <tr>
                <td><strong>{{ $cmd->reference_commande }}</strong></td>
                <td>
                    <div style="font-weight:600">{{ $cmd->user->prenom ?? '—' }} {{ $cmd->user->nom ?? '' }}</div>
                    <div style="font-size:0.8em; color:#888">{{ $cmd->user->email ?? '' }}</div>
                </td>
                <td style="font-weight:700; color:#10b981">{{ number_format($cmd->montant_total, 0, ',', ' ') }} FCFA</td>
                <td>
                    @if($cmd->statut === 'payé')
                        <span class="badge badge-success">✅ Payé</span>
                    @elseif($cmd->statut === 'en_attente')
                        <span class="badge badge-warning">⏳ En attente</span>
                    @else
                        <span class="badge badge-danger">❌ Annulé</span>
                    @endif
                </td>
                <td>
                    @if($cmd->paiement)
                        <span class="badge badge-info">{{ $cmd->paiement->provider }}</span>
                    @else
                        <span style="color:#ccc; font-size:0.85em">—</span>
                    @endif
                </td>
                <td style="font-size:0.85em; color:#888">{{ $cmd->created_at->format('d/m/Y H:i') }}</td>
                <td><a href="{{ route('admin.commandes.show', $cmd->id) }}" class="btn btn-sm btn-primary">Détail</a></td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#888; padding:40px">Aucune commande</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($commandes->hasPages())
    <div style="padding:20px; border-top:1px solid #f0f0f0">{{ $commandes->links() }}</div>
    @endif
</div>
@endsection
