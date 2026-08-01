<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = [
        'fecha',
        'tipo',
        'cuenta',
        'categoria',
        'descripcion',
        'importe',
    ];
}