<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajadors extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombres', 
        'apellido_paterno', 
        'apellido_materno', 
        'dni', 
        'fecha_nacimiento', 
        'sexo', 
        'cantidad_hijos', 
        'foto', 
        'area', 
        'cargo', 
        'fecha_ingreso', 
        'sueldo_base',
        'asignacion_familiar', 
        'sueldo_bruto', 
        'descuento_afp_obligatoria',
        'descuento_afp_comision', 
        'descuento_renta_5ta', 
        'descuento_eps', 
        'sueldo_neto'
    ];
}
