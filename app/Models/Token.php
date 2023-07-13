<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    public function cartao()
    {
        return $this->belongsTo(Cartao::class);
    }

    public function setServidorAttribute($value)
    {
        $this->attributes['token'] = mb_strtoupper($value);
    }

    public static function gerarToken($cartao)
    {
        $token = Token::where('cartao_id', $cartao->id)->get();
        if ($token->count()) {
            Token::where('cartao_id', $cartao->id)->delete();
        }
        for ($i = 1; $i <= $cartao->qtdToken; $i++) {
            $t =  new Token();
            $t->setServidorAttribute(substr(md5(time() . rand(10, 100)), 0, 8));
            $t->posicao  = $i;
            $t->cartao()->associate($cartao)->save();
        }
    }
}
