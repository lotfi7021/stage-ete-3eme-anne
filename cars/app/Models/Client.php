<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [ 'nom',
    'prenom',
    'nom_de_la_societe',
    'code_TVA',
    'adresse',
    'telephone',
    'Email',


];
   
}
