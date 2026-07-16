@extends('admin.layouts.app')

@section('title', 'Utilisateurs')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>👥 Utilisateurs ({{ $utilisateurs->total() }})</h2>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Commandes</th>
                <th>Inscrit le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($utilisateurs as $u)
            <tr>
                <td><strong>#{{ $u->id }}</strong></td>
                <td>
                    <div style="display:flex; align-items:center; gap:10px">
                        <div style="width:36px; height:36px; background:{{ $u->role === 'admin' ? '#667eea' : '#10b981' }}; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:0.85em; flex-shrink:0">
                            {{ strtoupper(substr($u->prenom, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600">{{ $u->prenom }} {{ $u->nom }}</div>
                            <div style="font-size:0.8em; color:#888">{{ $u->email }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:#888; font-size:0.9em">{{ $u->telephone ?? '—' }}</td>
                <td>
                    @if($u->role === 'admin')
                        <span class="badge badge-info">👑 Admin</span>
                    @else
                        <span class="badge badge-success">👤 Client</span>
                    @endif
                </td>
                <td><span class="badge badge-warning">{{ $u->commandes_count }}</span></td>
                <td style="font-size:0.85em; color:#888">{{ $u->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex; gap:5px">
                        @if($u->id !== auth()->id())
                        <form action="{{ route('admin.utilisateurs.toggle', $u->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-warning" title="{{ $u->role === 'admin' ? 'Rétrograder en client' : 'Promouvoir admin' }}">
                                {{ $u->role === 'admin' ? '👤' : '👑' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.utilisateurs.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                        </form>
                        @else
                        <span style="font-size:0.8em; color:#888">Vous</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#888; padding:40px">Aucun utilisateur</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($utilisateurs->hasPages())
    <div style="padding:20px; border-top:1px solid #f0f0f0">{{ $utilisateurs->links() }}</div>
    @endif
</div>
@endsection
