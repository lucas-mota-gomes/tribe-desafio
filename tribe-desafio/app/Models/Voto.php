<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    protected $fillable = [
        'user_id',
        'idea_id',
        'tipo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ideia()
    {
        return $this->belongsTo(Ideia::class);
    }
}