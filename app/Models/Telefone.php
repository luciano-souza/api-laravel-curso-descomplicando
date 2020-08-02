<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    //
    protected $fillable = [
        'numero', 'cliente_id',
    ];

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente');
    }
}
