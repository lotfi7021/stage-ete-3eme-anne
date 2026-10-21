<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCommandeM extends Model
{
    use HasFactory;

    protected $table = 'detail_commande_m_s';

    protected $fillable = [
        'ref_commande',
        'id_produit',
        'prix',
        'qte',
    ];

    public function commande()
    {
        return $this->belongsTo(CommandeM::class, 'ref_commande', 'ref_commande');
    }

    public function produit()
    {
        return $this->belongsTo(GestionMachine::class, 'id_produit');
    }
}
