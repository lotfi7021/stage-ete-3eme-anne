<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'status'


    ];

    protected $hidden = [
        'password'
    ];
}
