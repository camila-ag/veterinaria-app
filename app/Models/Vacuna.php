<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_adm',
        'fecha_prox',
        'vacuna',
        'marca',
        'obs',
        'paciente_id',
        'user_id',
    ];

    public function paciente()
    {
        return $this->belongsTo('App\Models\Paciente','id','paciente_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','id','user_id');
    }
}
