<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'nom',
        'prenom',
        'login',
        'password',
        'groupe',
        'role',
        'nom_de_la_societe',
        'code_TVA',
        'adresse',
        'telephone',
        'Email',
        'region',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    public function commandes()
    {
        return $this->hasMany(CommandeM::class, 'id_client');
    }

    public function livraisons()
    {
        return $this->hasMany(CommandeM::class, 'id_livreur');
    }

    public function supports()
    {
        return $this->hasMany(Support::class, 'id_client');
    }
}
