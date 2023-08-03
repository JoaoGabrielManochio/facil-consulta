<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medico extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'nome',
        'especialidade',
        'cidade_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'especialidade' => 'string',
        'cidade_id' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cidades()
    {
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function medicosPacientes()
    {
        return $this->hasMany(MedicoPaciente::class, 'medico_id');
    }
}
