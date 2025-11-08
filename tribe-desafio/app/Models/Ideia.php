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
}
