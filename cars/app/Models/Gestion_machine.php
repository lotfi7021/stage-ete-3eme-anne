<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion_machine extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

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
        return $this->belongsTo(Model_machine::class, 'model_id');
    }

    public function stock()
    {
        return $this->hasOne(stock_machine::class, 'id_produit');
    }

    public function detailsCommande()
    {
        return $this->hasMany(Detail_commandeM::class, 'id_produit');
    }
}
