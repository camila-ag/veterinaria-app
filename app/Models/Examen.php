<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;
    protected $table = 'examenes';
    protected $fillable = [
        'nombre',
        'examen',
        'paciente_id',
    ];

    public function paciente()
    {
        return $this->belongsTo('App\Models\Paciente','id','paciente_id');
    }
}
