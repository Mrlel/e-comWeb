<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    public function index()
    {
        $utilisateurs = User::withCount('commandes')->latest()->paginate(15);
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    public function toggleRole($id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => $user->role === 'admin' ? 'client' : 'admin']);
        return redirect()->back()->with('success', 'Rôle mis à jour');
    }

    public function destroy($id)
    {
        if (auth()->id() === (int)$id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Utilisateur supprimé');
    }
}
