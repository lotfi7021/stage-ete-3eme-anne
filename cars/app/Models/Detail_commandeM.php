<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_commandeM extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'ref_commande',
        'id_produit',
        'prix',
        'qte',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande_M::class, 'ref_commande', 'ref_commande');
    }

    public function produit()
    {
        return $this->belongsTo(Gestion_machine::class, 'id_produit');
    }
}
