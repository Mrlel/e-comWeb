@extends('admin.layouts.app')

@section('title', 'Catégories')

@push('styles')
<style>
    .cat-layout { display: grid; grid-template-columns: 1fr 380px; gap: 20px; }
    @media(max-width:800px) { .cat-layout { grid-template-columns: 1fr; } }
    .cat-thumb { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; background: #f0f0f0; }
    .cat-thumb-placeholder { width: 42px; height: 42px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #bbb; font-size: 0.75em; }
    .current-image-preview { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .current-image-preview img { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; }
</style>
@endpush

@section('content')
<div class="cat-layout">
    <!-- LISTE -->
    <div class="card">
        <div class="card-header">
            <h2>📂 Catégories ({{ $categories->count() }})</h2>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Produits</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td>
                        @if($cat->image)
                            <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->nom }}" class="cat-thumb">
                        @else
                            <div class="cat-thumb-placeholder">—</div>
                        @endif
                    </td>
                    <td><strong>{{ $cat->nom }}</strong></td>
                    <td style="color:#888; font-size:0.85em">{{ Str::limit($cat->description, 50) ?? '—' }}</td>
                    <td><span class="badge badge-info">{{ $cat->produits_count }}</span></td>
                    <td>
                        <div style="display:flex; gap:5px">
                            <button onclick="editCat({{ $cat->id }}, '{{ addslashes($cat->nom) }}', '{{ addslashes($cat->description) }}', '{{ $cat->image ? asset('storage/'.$cat->image) : '' }}')" class="btn btn-sm btn-warning">✏️</button>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" {{ $cat->produits_count > 0 ? 'disabled title=Catégorie non vide' : '' }}>🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; color:#888; padding:30px">Aucune catégorie</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- FORMULAIRE -->
    <div>
        <!-- CRÉER -->
        <div class="card" id="createForm">
            <div class="card-header"><h2>➕ Nouvelle catégorie</h2></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Nom *</label>
                        <input type="text" name="nom" class="form-control" required placeholder="Ex: Électronique">
                        @error('nom')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Description..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @error('image')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success" style="width:100%">Créer la catégorie</button>
                </form>
            </div>
        </div>

        <!-- MODIFIER (caché par défaut) -->
        <div class="card" id="editForm" style="display:none; margin-top:15px">
            <div class="card-header">
                <h2>✏️ Modifier la catégorie</h2>
                <button onclick="cancelEdit()" class="btn btn-sm btn-primary">Annuler</button>
            </div>
            <div class="card-body">
                <form method="POST" id="editFormAction" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label>Nom *</label>
                        <input type="text" name="nom" id="editNom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="editDesc" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <div id="editImagePreview" class="current-image-preview" style="display:none">
                            <img id="editImagePreviewImg" src="" alt="Image actuelle">
                            <span style="font-size:0.8em; color:#888">Image actuelle</span>
                        </div>
                        <label>Nouvelle image (laisser vide pour conserver)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @error('image')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-warning" style="width:100%">💾 Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editCat(id, nom, desc, imageUrl) {
        document.getElementById('editForm').style.display = 'block';
        document.getElementById('editFormAction').action = '/admin/categories/' + id;
        document.getElementById('editNom').value = nom;
        document.getElementById('editDesc').value = desc;
        const preview = document.getElementById('editImagePreview');
        const previewImg = document.getElementById('editImagePreviewImg');
        if (imageUrl) {
            previewImg.src = imageUrl;
            preview.style.display = 'flex';
        } else {
            preview.style.display = 'none';
        }
        document.getElementById('editForm').scrollIntoView({ behavior: 'smooth' });
    }
    function cancelEdit() {
        document.getElementById('editForm').style.display = 'none';
    }
</script>
@endpush
