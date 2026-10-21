<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeM extends Model
{
    use HasFactory;

    protected $table = 'commande__m_s';

    protected $fillable = [
        'ref_commande',
        'id_client',
        'prix',
        'tva',
        'date_livraison',
        'title',
        'start',
        'end',
        'id_livreur',
        'etat',
        'paiement',
    ];

    public function client()
    {
        return $this->belongsTo(Admin::class, 'id_client');
    }

    public function livreur()
    {
        return $this->belongsTo(Admin::class, 'id_livreur');
    }

    public function details()
    {
        return $this->hasMany(DetailCommandeM::class, 'ref_commande', 'ref_commande');
    }
}
