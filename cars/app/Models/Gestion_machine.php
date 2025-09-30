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

}
