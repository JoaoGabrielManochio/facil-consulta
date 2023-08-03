<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'nome',
        'cpf',
        'celular'
    ];

    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'cpf' => 'string',
        'celular' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function medicos()
    {
        return $this->hasMany(MedicoPaciente::class, 'paciente_id');
    }
}
