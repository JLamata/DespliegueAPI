<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plantasModel extends Model
{
    use HasFactory;
    protected $table= "plantas";
    protected $fillable=[
        'id',
        'nombre',
        'categoria',
        'precio',
        'cantidad',
        'imagenes'
    ];
    public $timestamps = false; 
}
