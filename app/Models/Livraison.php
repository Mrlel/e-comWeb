<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    protected $fillable = ['commande_id', 'adresse', 'ville', 'statut', 'date_livraison'];

    protected $casts = ['date_livraison' => 'datetime'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
