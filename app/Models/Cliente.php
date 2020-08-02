<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Telefone;

class Cliente extends Model
{
    //
    protected $fillable = [
        'nome', 'image', 'cpf_cnpj',
    ];

    public function telefones()
    {
        return $this->hasMany(Telefone::class);
    }
}
