@extends('admin.layouts.app')

@section('title', 'Gestion des produits')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>📦 Liste des produits ({{ $produits->total() }})</h2>
        <a href="{{ route('admin.produits.create') }}" class="btn btn-success">+ Ajouter un produit</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produit</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Créé le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produits as $p)
            <tr>
                <td><strong>#{{ $p->id }}</strong></td>
                <td>
                    <div style="display:flex; align-items:center; gap:10px">
                        <div style="width:40px; height:40px; background:#f0f0f0; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:1.2em">
                            @if($p->image)
                                <img src="{{ asset('storage/' . $p->image) }}" style="width:100%; height:100%; object-fit:cover; border-radius:8px">
                            @else
                                📦
                            @endif
                        </div>
                        <div>
                            <div style="font-weight:600">{{ $p->nom }}</div>
                            <div style="font-size:0.8em; color:#888">{{ Str::limit($p->description, 40) }}</div>
                        </div>
                    </div>
                </td>
                <td><span class="badge badge-info">{{ $p->categorie->nom ?? '—' }}</span></td>
                <td style="font-weight:700; color:#10b981">{{ number_format($p->prix, 0, ',', ' ') }} FCFA</td>
                <td>
                    @if($p->stock <= 5)
                        <span class="badge badge-danger">{{ $p->stock }}</span>
                    @else
                        <span class="badge badge-success">{{ $p->stock }}</span>
                    @endif
                </td>
                <td style="font-size:0.85em; color:#888">{{ $p->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex; gap:5px">
                        <a href="{{ route('admin.produits.edit', $p->id) }}" class="btn btn-sm btn-warning">✏️</a>
                        <form action="{{ route('admin.produits.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#888; padding:40px">Aucun produit</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($produits->hasPages())
    <div style="padding:20px; border-top:1px solid #f0f0f0">
        {{ $produits->links() }}
    </div>
    @endif
</div>
@endsection
