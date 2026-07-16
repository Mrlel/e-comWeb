<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('produits')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Categorie::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée');
    }

    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);
        $data = $request->validate([
            'nom'         => 'required|string|max:255|unique:categories,nom,' . $id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($categorie->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($categorie->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $categorie->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour');
    }

    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        if ($categorie->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($categorie->image);
        }
        $categorie->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée');
    }
}
