<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reference_commande', 'montant_total', 'statut', 'adresse_livraison'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    public function livraison()
    {
        return $this->hasOne(Livraison::class);
    }
}
