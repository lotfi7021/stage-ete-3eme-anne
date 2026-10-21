<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMachine extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_produit',
        'qte_initial',
        'mouvement',
        'qte_final',
    ];

    public function produit()
    {
        return $this->belongsTo(GestionMachine::class, 'id_produit');
    }
}
