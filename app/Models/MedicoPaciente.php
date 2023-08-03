<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicoPaciente extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'paciente_id',
        'medico_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'paciente_id' => 'integer',
        'medico_id' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function medicos()
    {
        return $this->hasMany(Medico::class, 'id', 'medico_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'id', 'paciente_id');
    }
}
