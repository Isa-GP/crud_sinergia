<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class paciente extends Model
{
  use HasFactory;
   protected $fillable = [
    'tipo_documento_id',
    'numero_documento',
    'nombre1',
    'nombre2',
    'apellido1',
    'apellido2',
    'genero_id',
    'departamento_id',
    'municipio_id',
    'correo',
];

}
