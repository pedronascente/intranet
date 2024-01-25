<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'posicao',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function gerarToken($user_id, $qtdToken)
    {
        $token = Token::where('user_id', $user_id)->get();
        
        if ($token->count()>=1) {
            Token::where('user_id', $user_id)->delete();
        }

        //criar novos tokens :
        for ($i = 1; $i <= $qtdToken; $i++) {
            $t =  new Token();
            $t->setServidorAttribute(substr(md5(time() . rand(10, 100)), 0, 8));
            $t->posicao = $i;
            $t->user_id = $user_id;
            $t->save();
        }
    }

    public static function validarToken($request)
    {
        $arrayListTokens = self::getTokenUsuarioLogado($request);
        foreach ($arrayListTokens as  $value) {
            if ($value->posicao == $request->posicaoDoToken && $value->token == $request->token) {
                return true;
                break;
            }
        }
        return false;
    }

    private function setServidorAttribute($value)
    {
        $this->attributes['token'] = mb_strtoupper($value);
    }

    private static function getTokenUsuarioLogado($request)
    {
        $arrayListTokens = self::with('user')
            ->where('user_id', $request->user()->id)
            ->get();
        return  $arrayListTokens;
    }
}
