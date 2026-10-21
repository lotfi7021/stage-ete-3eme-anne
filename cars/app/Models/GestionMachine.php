<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionMachine extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'titre',
        'description',
        'image1',
        'prix',
        'qte',
        'marque_id',
        'model_id',
    ];

    public function marque()
    {
        return $this->belongsTo(MarqueMachine::class, 'marque_id');
    }

    public function model()
    {
        return $this->belongsTo(ModelMachine::class, 'model_id');
    }

    public function stock()
    {
        return $this->hasOne(StockMachine::class, 'id_produit');
    }

    public function detailsCommande()
    {
        return $this->hasMany(DetailCommandeM::class, 'id_produit');
    }
}
