<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarqueMachine extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['titre'];

    public function gestionMachines()
    {
        return $this->hasMany(GestionMachine::class, 'marque_id');
    }
}
