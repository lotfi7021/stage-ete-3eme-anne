<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_machine extends Model
{
    use HasFactory;


    protected $primaryKey = 'id';
    protected $fillable = ['titre'];

}
