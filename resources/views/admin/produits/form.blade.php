@extends('admin.layouts.app')

@section('title', isset($produit) ? 'Modifier le produit' : 'Nouveau produit')

@push('styles')
<style>
    .form-card { max-width: 750px; }
    .image-preview { width: 120px; height: 120px; background: #f0f0f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 3em; overflow: hidden; margin-bottom: 10px; }
    .image-preview img { width: 100%; height: 100%; object-fit: cover; }
</style>
@endpush

@section('content')
<div class="card form-card">
    <div class="card-header">
        <h2>{{ isset($produit) ? '✏️ Modifier : ' . $produit->nom : '➕ Nouveau produit' }}</h2>
        <a href="{{ route('admin.produits.index') }}" class="btn btn-sm btn-primary">← Retour</a>
    </div>
    <div class="card-body">
        <form method="POST"
              action="{{ isset($produit) ? route('admin.produits.update', $produit->id) : route('admin.produits.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($produit)) @method('PUT') @endif

            <div class="form-row">
                <div class="form-group">
                    <label>Nom du produit *</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom', $produit->nom ?? '') }}" required placeholder="Ex: iPhone 15 Pro">
                    @error('nom')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Catégorie *</label>
                    <select name="categorie_id" class="form-control" required>
                        <option value="">-- Choisir --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('categorie_id', $produit->categorie_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nom }}
                        </option>
                        @endforeach
                    </select>
                    @error('categorie_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Prix (FCFA) *</label>
                    <input type="number" name="prix" class="form-control" value="{{ old('prix', $produit->prix ?? '') }}" required min="0" placeholder="Ex: 25000">
                    @error('prix')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Stock *</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $produit->stock ?? 0) }}" required min="0">
                    @error('stock')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Description du produit...">{{ old('description', $produit->description ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label>Image du produit</label>
                @if(isset($produit) && $produit->image)
                <div class="image-preview">
                    <img src="{{ asset('storage/' . $produit->image) }}" alt="Image actuelle">
                </div>
                <div style="font-size:0.8em; color:#888; margin-bottom:8px">Image actuelle — Choisir une nouvelle pour remplacer</div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*" id="imageInput">
                <div class="image-preview" id="imagePreview" style="{{ isset($produit) && $produit->image ? 'display:none' : '' }}">📷</div>
                @error('image')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex; gap:10px; margin-top:10px">
                <button type="submit" class="btn btn-success">
                    {{ isset($produit) ? '💾 Enregistrer les modifications' : '➕ Créer le produit' }}
                </button>
                <a href="{{ route('admin.produits.index') }}" class="btn btn-primary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (ev) => {
                preview.innerHTML = `<img src="${ev.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:12px">`;
                preview.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
