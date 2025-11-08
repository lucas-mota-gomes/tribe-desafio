<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ideia extends Model
{
    protected $fillable = ['titulo', 'descricao', 'autor_id'];

    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function votos()
    {
        return $this->hasMany(Voto::class, 'ideia_id');
    }

    public function votosPositivos()
    {
        return $this->votos()->where('tipo', 'positivo')->count();
    }

    public function votosNegativos()
    {
        return $this->votos()->where('tipo', 'negativo')->count();
    }

    public function totalVotos()
    {
        return $this->votosPositivos() - $this->votosNegativos();
    }
}
