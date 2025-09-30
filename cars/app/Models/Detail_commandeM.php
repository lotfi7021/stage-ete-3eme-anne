<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_commandeM extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['ref_commande',
    'id_produit',
    'prix',
    'qte',
   
];
}
