<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';
    protected $fillable = ['nombre', 'apellido', 'edad', 'email', 'telefono', 'grupo_id'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
