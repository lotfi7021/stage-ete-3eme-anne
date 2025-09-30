<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_machine extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['id_produit','qte_initial','mouvement','qte_final'];

}
